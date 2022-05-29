<?php

/**
 * BaseController is used as a basic controller to extend from
 * 
 * @author ReneRuprecht
 */
abstract class BaseController
{
    /**
     * createView is a basic function every controller needs
     *
     * @return void
     */
    public function createView(): void
    {
        echo "<h1>basic view </h1>";
    }
}
