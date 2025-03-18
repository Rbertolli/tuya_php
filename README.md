# Tuya PHP

A PHP client for the Tuya API, organized into a modular structure with support for generic functionalities and specific smart-lock features. This project uses Composer for dependency management and [phpdotenv](https://github.com/vlucas/phpdotenv) to securely load credentials from environment variables.

## Features

- **Generic Tuya Client:** Communicate with the Tuya API for token retrieval and device information.
- **Smart-Lock Functions:** Specific smart-lock functionalities, including:
  - Retrieving a password ticket for smart locks.
  - Encrypting a numeric password.
  - Creating a temporary password.

## Requirements

- PHP 7.2 or higher
- PHP extensions: `curl`, `openssl`
- [Composer](https://getcomposer.org/)

## Installation via Composer

If you want to install this package directly into your project, you can use Composer:

```bash
composer require rbertolli/tuya-php
```

This will automatically download and install the package along with its dependencies.

## Download & Manual Installation

1. **Download the Repository**

   You can clone the repository via Git:

   ```bash
   git clone https://github.com/Rbertolli/tuya_php.git
   cd tuya_php
   ```

2. **Install Dependencies**

   Use Composer to install all required dependencies:

   ```bash
   composer install
   ```

3. **Set Up Environment Variables**

   Create a `.env` file in the root directory of the project with the following content:

   ```dotenv
   TUYA_CLIENT_ID=your_client_id
   TUYA_CLIENT_SECRET=your_client_secret
   TUYA_API_URL=https://api.tuya.com
   TUYA_TOKEN_CACHE_FILE=./token_cache.json
   ```

## Usage

You can use both generic functionalities and smart-lock-specific functions. Below is an example that demonstrates how to use the client.

```php
<?php

require 'vendor/autoload.php';

use Dotenv\Dotenv;
use Tuya\TuyaClient;
use Tuya\SmartLock;

// Load environment variables from .env file
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Retrieve credentials from environment variables
$clientId       = $_ENV['TUYA_CLIENT_ID'];
$clientSecret   = $_ENV['TUYA_CLIENT_SECRET'];
$apiUrl         = $_ENV['TUYA_API_URL'] ?? 'https://api.tuya.com';
$tokenCacheFile = $_ENV['TUYA_TOKEN_CACHE_FILE'] ?? __DIR__ . '/token_cache.json';

// --- Generic Tuya Client Usage ---
// Instantiate the basic client
$tuyaClient = new TuyaClient($clientId, $clientSecret, $apiUrl, $tokenCacheFile);

// Get device information
$deviceInfo = $tuyaClient->getDeviceInfo('device_id_here');
print_r($deviceInfo);

// --- Smart-Lock Specific Usage ---
// Instantiate the SmartLock client
$smartLock = new SmartLock($clientId, $clientSecret, $apiUrl, $tokenCacheFile);

// Retrieve a password ticket for a smart-lock device
$ticketResponse = $smartLock->getPasswordTicket('device_id_here');
print_r($ticketResponse);

// Encrypt a numeric password (for example, "123456")
$plainPassword = "123456";
$debug = [];
$encryptedPassword = $smartLock->encryptNumericPassword($plainPassword, $ticketResponse['result']['ticket_key'], $debug);
echo "Encrypted Password: " . $encryptedPassword . "
";

// Build payload for creating a temporary password
$payload = [
    "name"           => "TP" . sprintf("%08d", rand(0, 99999999)),
    "password"       => $encryptedPassword,
    "effective_time" => time() + 24 * 3600, // Effective in 24 hours
    "invalid_time"   => time() + 48 * 3600, // Expires in 48 hours
    "password_type"  => "ticket",
    "ticket_id"      => $ticketResponse['result']['ticket_id'],
    "type"           => 0,  // Multiple use
    "time_zone"      => "",
    "phone"          => ""
];

// Create the temporary password for the smart-lock device
$tempPasswordResponse = $smartLock->createTempPassword('device_id_here', $payload);
print_r($tempPasswordResponse);
```

## Production Deployment

When deploying to production (for example, using DigitalOcean's App Platform), you should set your environment variables directly in the platform's configuration. This way, the project will work without relying on a `.env` file.

## Contributing

Contributions are welcome! Feel free to open issues or submit pull requests to help improve the project or add new functionalities. 

## License

This project is licensed under the [MIT License](LICENSE).
