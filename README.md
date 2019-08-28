## Jam for Laravel 5

A Laravel 5 service provider for the AWS DynamoDB [session handler](https://aws.amazon.com/blogs/aws/scalable-session-handling-in-php-using-amazon-dynamodb/).

NOTE: In the Laravel 5.8 [release notes](https://laravel.com/docs/5.8/releases) it was announced that DynamoDB session drivers are now baked into the framework itself. As a reault, this package should not be required for Laravel v5.8 and above.

```
composer require fivesqrd/jam-laravel
```

## Configuration ##

.env requirements
```
SESSION_DRIVER=dynamodb
SESSION_LIFETIME=1440
SESSION_TABLE="My-Table-Name"

AWS_ACCESS_KEY_ID="my-key"
AWS_SECRET_ACCESS_KEY="my-secret"
AWS_DEFAULT_REGION="eu-west-1"
#AWS_ENDPOINT="http://localhost:8000"
```

## Create DynamoDB table ##
For production environments it's important to use the AWS Management Console to create the table. This is to ensure the correct billing and throughput settings are applied. The only requirement is that the table has a partition key of 'id'. For garbage collection you can set your TTL attribute to 'expires'

For [local DynamoDB](https://docs.aws.amazon.com/amazondynamodb/latest/developerguide/DynamoDBLocal.html) servers and dev environments the following artisan command is available:
```
php artisan make:jam
```

## IAM Permissions ##
Allowing the session handler access to the table requires the following IAM permissions:
```
{
  "Version": "2012-10-17",
  "Statement": [
        {
            "Action": [
                "dynamodb:GetItem",
                "dynamodb:UpdateItem",
                "dynamodb:DeleteItem",
                "dynamodb:Scan",
                "dynamodb:BatchWriteItem"
            ],
            "Effect": "Allow",
            "Resource": "arn:aws:dynamodb:<region>:<account-id>:table/<table-name>"
        }
    ]
}
```
