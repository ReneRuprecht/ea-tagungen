<?php
include_once('RepositoryInterface.php');
/**
 * JsonRepository  class to get the data from the json file
 */
class JsonRepository implements RepositoryInterface
{
    /**
     * file contains the filepath of the json file
     *
     * @var [string]
     */
    private $file;

    /**
     * connect simulates the connection to the filestorage. sets the conntection
     *
     * @param [string] $connectionString
     * @return void
     */
    public function connect($connectionString):void 
    {
        $this->file = $connectionString;
    }

    /**
     * readFromRepository reads the data from the file
     *
     * @return array event
     */
    public function readFromRepository(): array
    {

        // if the file doesn't exist, the file get created
        if (!file_exists($this->file)) {
            file_put_contents($this->file, defaultJson);
            return json_decode(defaultJson, true);
        }

        // reads data from file
        $fileContent = file_get_contents($this->file);

        // puts an empty array into file
        if ($fileContent == null || $fileContent == "") {
            file_put_contents($this->file, defaultJson);
            return json_decode(defaultJson, true);
        }

        return json_decode($fileContent, true);
    }

    /**
     * saveSingleEvent saves the single event to file
     *
     * @param [Event] $singleEventArray
     * @return void
     */
    public function saveSingleEvent($singleEventArray):void
    {

        $fileJson = $this->readFromRepository();        

        // get set to true if the timeslot already exist
        $timeslotExists = false;

        /*
        * loop to find the timeslot in the current data if there is a event to
        * add the timeslot, the loop breaks if there is no event to add the new
        * timeslot, the timeslotExists stays false
         */
        foreach ($fileJson['events'] as $key => $value) {
            if ($value['eventDate'] == $singleEventArray['eventDate']) {
                foreach ($singleEventArray['timeslots'] as $singleTimeSlot) {
                    // adds the new event timeslot to the existing timeslot
                    array_push($fileJson['events'][$key]['timeslots'], $singleTimeSlot);
                }
                // timeslot exists already
                $timeslotExists = true;
                break;
            }
        }

        /*
        * adds the timeslot to a new entry because the time slot doesn't existed
        * before
        */
        if (!$timeslotExists) {
            array_push($fileJson['events'], $singleEventArray);
        }

        // saves the data into the file
        file_put_contents($this->file, json_encode($fileJson, JSON_PRETTY_PRINT));
    }
}
