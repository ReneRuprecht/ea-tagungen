<?php

/**
 * RepositoryInterface  handles the connection as well as read and saving of
 * data
 * 
 * @author ReneRuprecht
 */
interface RepositoryInterface
{
    /**
     * connect, connects to the storage
     *
     * @param [string] $connectionString
     * @return void
     */
    public function connect($connectionString): void;

    /**
     * readFromRepository reads the data from the storage
     *
     * @return array event
     */
    public function readFromRepository(): array;

    /**
     * saveSingleEvent saves the single event to the storage
     *
     * @param [Event] $singleEventArray
     * @return void
     */
    public function saveSingleEvent($singleEventArray): void;
}
