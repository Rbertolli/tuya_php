# Tuya PHP

This is a PHP client for interacting with the Tuya API, including support for Smart Locks and serverless deployment.

### **🔹 One-Click Deploy**
You can deploy this project on **DigitalOcean** with a single click and get **$200 in credits** when creating an account.

[![Deploy to DigitalOcean](https://www.deploytodo.com/do-btn-blue.svg)](https://cloud.digitalocean.com/apps/new?repo=https://github.com/Rbertolli/tuya_php/tree/main)

## 📖 Features

- **Generic Tuya Client:** Communicate with the Tuya API for token retrieval and device information.
- **Smart-Lock Functions:** Specific smart-lock functionalities, including:
  - Retrieving a password ticket for smart locks.
  - Encrypting a numeric password.
  - Creating a temporary password.
- Serverless functions support.
- Click-to-Deploy on DigitalOcean App Platform.
- Easy integration with PHP applications.

## ⚙️ Requirements

- PHP 7.2 or higher
- PHP extensions: `curl`, `openssl`
- [Composer](https://getcomposer.org/)

## 📜 Environment Variables

Configure your `.env` file with the following:
```
TUYA_API_KEY=your_api_key_here
TUYA_API_SECRET=your_api_secret_here
TUYA_REGION=your_region_here
```

## 🌐 How to Generate Tuya API Credentials

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

## 🌐 Serverless Functions

This project supports DigitalOcean Functions for seamless API execution.

### Example Requests

You can test the API using the `examples/requests.http` file or with cURL/Postman.

#### 🔐 Authenticate with Tuya API
```http
GET {{base_url}}/functions/login.php
```

#### 🔑 Create a Temporary Smart Lock Password
```http
GET {{base_url}}/functions/smart_lock.php?device_id=YOUR_DEVICE_ID&password=123456&start_time=1713456000&end_time=1713542400
```

## 🛠 Click-to-Deploy

To deploy on DigitalOcean App Platform, simply use the `do_config/project.yml` configuration.

## 🏗 Contributing

Contributions are welcome! Feel free to open issues or submit pull requests.
If you have any questions, contact us via email at **opensource@bertolli.com.br**.

## 📄 License

This project is licensed under the MIT License.
