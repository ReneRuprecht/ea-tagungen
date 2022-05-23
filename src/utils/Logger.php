<?php

class Logger
{
    public function log($data)
    {
        echo '<script>';
        echo 'console.log("' . $data . '")';
        echo '</script>';
    }
}
