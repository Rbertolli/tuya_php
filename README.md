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

## How to Generate Tuya API Credentials

To use this package, you must first obtain API credentials from Tuya. Follow these steps:

### **1. Create a Tuya Developer Account**
1. Go to [Tuya IoT Platform](https://iot.tuya.com/).
2. Sign up or log in to your **Tuya Developer Account**.

### **2. Create a Cloud Project**
1. Navigate to **Cloud Development** and select **Create Cloud Project**.
2. Fill in the project details:
   - **Development Method**: Custom Development
   - **Industry**: Select based on your use case (e.g., Smart Home).
   - **Data Center**: Choose the closest data center to your location.
   - **API Services**: Select the necessary API services (e.g., Smart Home, Device Control).
3. Click **Create**.

### **3. Retrieve API Credentials**
Once your project is created, go to **Project Details** and find:
- **Client ID** (`TUYA_CLIENT_ID`)
- **Client Secret** (`TUYA_CLIENT_SECRET`)

### **4. Link Your Tuya Devices**
1. In the **Cloud Project**, go to **Devices**.
2. Click **Link Tuya App Account**.
3. Scan the QR Code using the **Tuya Smart App**.
4. After linking, all devices in your Tuya App will be available via API.

### **5. Set Up Environment Variables**
Create a `.env` file in the root directory of the project with the following content:

```dotenv
TUYA_CLIENT_ID=your_client_id
TUYA_CLIENT_SECRET=your_client_secret
TUYA_API_URL=https://api.tuya.com
TUYA_TOKEN_CACHE_FILE=./token_cache.json
```

## Production Deployment

When deploying to production (for example, using DigitalOcean's App Platform), you should set your environment variables directly in the platform's configuration. This way, the project will work without relying on a `.env` file.

## Contributing

Contributions are welcome! Feel free to open issues or submit pull requests to help improve the project or add new functionalities.

## License

This project is licensed under the [MIT License](LICENSE).


## Deploy na DigitalOcean 🚀

Agora você pode facilmente rodar este projeto na [DigitalOcean](https://www.digitalocean.com/?refcode=e6dcb42c53c3&utm_campaign=Referral_Invite&utm_medium=Referral_Program&utm_source=badge) e ganhar **U$200 em créditos** ao criar sua conta.

<a href="https://www.digitalocean.com/?refcode=e6dcb42c53c3&utm_campaign=Referral_Invite&utm_medium=Referral_Program&utm_source=badge">
    <img src="https://web-platforms.sfo2.cdn.digitaloceanspaces.com/WWW/Badge%201.svg" alt="DigitalOcean Referral Badge" />
</a>
