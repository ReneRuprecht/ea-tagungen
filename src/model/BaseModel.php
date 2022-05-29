<?php

/**
 * BaseModel is used as a basic model to extend from
 * 
 * @author ReneRuprecht
 */
abstract class BaseModel
{
    /**
     * toString to return a printable string
     *
     * @return string
     */
    abstract public function toString(): string;

    /**
     * toArray builds an array from the object instance
     *
     * @return array
     */
    abstract public function toArray(): array;
}
