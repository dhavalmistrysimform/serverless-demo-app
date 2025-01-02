# Serverless Demo Application 🖥️⚡  

Welcome to the **Serverless Demo Application**! This Laravel application demonstrates how to deploy a web application on **AWS Lambda** using the **Bref** package and **Serverless Framework**. Perfect for exploring serverless architecture with Laravel! 🌐💡  

---

## Features ✨  

- **Serverless Laravel:** Deploy Laravel effortlessly on AWS Lambda using the Bref package.  
- **AWS SQS Integration:** Queue job handling using AWS SQS.  
- **Simple and Scalable:** Focused setup to demonstrate serverless architecture.  
- **Log Insights:** Logs an entry every time the `/` route is hit.  
- **Event-Driven:** Dispatches a queued job to process events efficiently.  

---

## Prerequisites 📋  

Make sure you have the following installed before getting started:  

- PHP 8.1+  
- Composer  
- Node.js & NPM (node version must be >= 18)
- AWS CLI (configured with credentials)  
- Serverless Framework (`npm install -g serverless`)  

---

## Getting Started 🛠️  

### 1️⃣ Clone the Repository  

```bash
git clone https://github.com/yourusername/serverless-demo-application.git
cd serverless-demo-application
```
### 2️⃣ Install Dependencies

Run the following command to install all the required PHP and Node.js dependencies:

```bash
composer install
npm install
```

## 3️⃣ Configure Your Environment

Create a `.env` file in the project root:

```bash
cp .env.example .env
```

## 4️⃣ Serverless Configuration 📝

The serverless configuration is defined in the `serverless.yml` file. Key settings include:

- **Service Name**: `serverless-demo-application`
- **Provider Region**: `us-east-1`
- **Excluded Files**: Unnecessary files are excluded for optimized deployment.
- **Handler**: `public/index.php` serves as the entry point.

Here’s an overview of the configuration file:

```yaml
# "org" ensures this Service is used with the correct Serverless Framework Access Key.
org: simform2388
service: serverless-demo-application

provider:
    name: aws
    # The AWS region in which to deploy (us-east-1 is the default)
    region: us-east-1
    # Environment variables
    environment:
        APP_ENV: production # Or use ${sls:stage} if you want the environment to match the stage
        SESSION_DRIVER: cookie # Change to database if you have set up a database

package:
    # Files and directories to exclude from deployment
    patterns:
        - '!node_modules/**'
        - '!public/storage'
        - '!resources/assets/**'
        - '!storage/**'
        - '!tests/**'
        - '!database/*.sqlite'

functions:

    # This function runs the Laravel website/API
    web:
        handler: public/index.php
        runtime: php81-fpm
        timeout: 28 # in seconds (API Gateway has a timeout of 29 seconds)
        events:
            - httpApi: '*'

plugins:
    # We need to include the Bref plugin
    - ./vendor/bref/bref
```

## 5️⃣ Deploy the Application to AWS Lambda 🌍

Now, you're ready to deploy the application to AWS Lambda! Run the following command:

```bash
serverless deploy
```

Once the deployment is complete, you’ll receive a URL from AWS API Gateway that you can use to access the application.

```bash
https://your-api-gateway-url.amazonaws.com
```

## 6️⃣ Routes and Logic 🚦

### / Route

When the `/` route is accessed, the following actions occur:

- A log message is created: "I was inside the serverless architecture".
- A background job is dispatched using AWS SQS to handle queued tasks.

The route looks like this:

```php
Route::get('/', function () {
    logger()->info('I was inside the serverless architecture');
    ProcessTrasactionJob::dispatch();  // Dispatch a job via AWS SQS
    return view('welcome');
});
```

## 7️⃣ AWS SQS Integration 📬
The application utilizes AWS SQS for handling background jobs. Here's how you can configure it:

Create an SQS queue in the AWS Console.
Add the SQS queue URL and necessary credentials to your `.env` file.

## 8️⃣ Running Locally 🚀

You can also run the application locally to test its functionality:

```bash
php artisan serve
```
Then access the application at:
```bash
http://localhost:8000
```

## 9️⃣ Logs and Monitoring 📈

Use the following command to view the logs from AWS Lambda:

```bash
serverless logs -f web
```