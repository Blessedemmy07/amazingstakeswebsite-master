<?php

namespace App\Configs;

use App\Configs\Configurations; 

class ErrorLogger {
    private $handle;
    private $logFilePath = '../public/logs/errors.log'; // Set the log file path

    public function __construct() {
        // Open the log file in append mode
        $this->handle = fopen($this->logFilePath, 'a');
        if (!$this->handle) {
            throw new \Exception("Could not open the log file for writing.");
        } 

        // Instantiate Configurations Class
        $configsEnv = new Configurations();

        // Set the timezone for the website
        $configsEnv->SetTimezone();
    }

    public function WriteError($message) {
        // Write the error message to the log file
        if ($this->handle) {
            fwrite($this->handle, date('Y-m-d G:i:s') . ' - ' . print_r($message, true) . "\n");
        }
    }

    public function __destruct(){
        // Close the file handle in the destructor
        if ($this->handle) {
            fclose($this->handle);
        }
    }
}
