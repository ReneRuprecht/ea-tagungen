<?php

interface RepositoryInterface
{
    public function __construct($logger);
    public function connect($connectionString);
    public function read();
    public function save($data);
    public function findAllDates();
}
