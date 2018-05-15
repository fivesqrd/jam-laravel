## Jam

A Laravel 5 service provider for the AWS DynamoDB [session handler](https://aws.amazon.com/blogs/aws/scalable-session-handling-in-php-using-amazon-dynamodb/).

```
composer require fivesqrd/jam
```

.env requirements
```
SESSION_DRIVER=dynamodb
SESSION_LIFETIME=1440
SESSION_TABLE="My-Table-Name"

AWS_KEY="my-key"
AWS_SECRET="my-secret"
AWS_REGION="eu-west-1"
#AWS_ENDPOINT="http://192.168.254.10:8000"
```