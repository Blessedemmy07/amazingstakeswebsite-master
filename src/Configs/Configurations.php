<?php
namespace App\Configs;

use Dotenv\Dotenv; // Import the Dotenv class

class Configurations {  // Updated to match file name

    public $env_file_path = "../"; // Path to the directory containing the .env file

    // Execute the sharable env vendor class
    public function __construct() {
        // Load the .env file
        $dotenv = Dotenv::createImmutable($this->env_file_path);
        $dotenv->load();
    }

    public function GetAppConfigs(): array {
        return [
            "app_name" => $_ENV["APP_NAME"] ?? null, // Use null coalescing for safety
            "app_env" => $_ENV["APP_ENV"] ?? null,
            "app_debug" => $_ENV["APP_DEBUG"] ?? null,
            "app_url" => $_ENV["APP_URL"] ?? null,
            "app_timezone" => $_ENV["APP_TIMEZONE"] ?? null, // Include timezone if needed
        ];
    }

    public function GetDatabaseConfigs(): array {
        return [
            "db_connection" => $_ENV["DB_CONNECTION"] ?? null,
            "db_host" => $_ENV["DB_HOST"] ?? null,
            "db_port" => $_ENV["DB_PORT"] ?? null,
            "db_database" => $_ENV["DB_DATABASE"] ?? null,
            "db_username" => $_ENV["DB_USERNAME"] ?? null,
            "db_password" => $_ENV["DB_PASSWORD"] ?? null,
        ];
    }

    public function SetTimezone() {
        // Set the timezone from the application configurations
        if (isset($_ENV["APP_TIMEZONE"])) {
            date_default_timezone_set($_ENV["APP_TIMEZONE"]);
        } else {
            // Optionally handle the case where the timezone is not set
            date_default_timezone_set('UTC'); // Fallback to UTC or any default timezone
        }
    }
}
