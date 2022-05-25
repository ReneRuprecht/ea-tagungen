<?php

interface RepositoryInterface
{
    public function __construct($logger);
    public function connect($connectionString);
    public function readFromRepository();
    public function saveSingleEvent($singleEventArray);
}
