<?php

/**
 * Validator, is used to implement
 * 
 * @author ReneRuprecht
 */
interface Validator
{
    /**
     * validate, checks if something is valid
     *
     * @return string message
     */
    public function validate(): string;
}
