Framework agnostic PHP wrapper around reqres APIs.

# Installation

In your Service Container, bind the interface `UserServiceInterface` to a new instance of `UserService`.

`UserService` accepts an optional `Psr\Log\LoggerInterface` object in the constructor. All HTTP logs will be forwarded
to the passed logger.

## Laravel example

Example of implementation with Laravel.

In your `ServiceProvider`:

```php
$this->app->bind(UserServiceInterface::class, function (Application $app) {
    return new UserService(\Log::getLogger());
});
```

Then use Dependency Injection within your own service.
Example:

```php
class MyService {
    private UserServiceInterface $userService;

    public function __construct(UserServiceInterface $userService) {
        $this->userService = $userService;
    }
    
    public function getUserFromId(int $id): UserDTO {
        return $this->userService->getUserFromId($id);
    }

}
```

# Usage

## Methods

| Name                | Description                                                   | Returns                                           |
|---------------------|---------------------------------------------------------------|---------------------------------------------------|
| `getUserFromId`     | Retrieve a user from a user's `int $id`.                      | Return a `UserDTO` or null if the user is not found |
| `createUser`        | Creates a user with a `string $name` and `string $job`.       | Return the user ID                                |
| `getUsersPaginated` | Retrieve a paginated list of users from a `int $page` number. | Returns a `UserPaginatedListDTO`                        |

## DTO

### UserDTO

| Property    | Type    | Comment |
|-------------|---------|---------|
| `id`        | Integer |         |
| `email`     | String  |         |
| `firstName` | String  |         |
| `lastName`  | String  |         |
| `avatar`    | String  |         |

### UserPaginatedListDTO

| Property     | Type             | Comment      |
|--------------|------------------|--------------|
| `page`       | Integer          |              |
| `perPage`    | Integer          |              |
| `total`      | Integer          |              |
| `totalPages` | Integer          |              |
| `list`       | Array\<UserDTO\> | Can be empty |

## Exceptions

| Name                             | Description                                                                          |
|----------------------------------|--------------------------------------------------------------------------------------|
| `DomainBaseException`            | Default exception, all exception of this module will inherit this class        |
| `HttpException`                  | Http exception, occurs when the distant API server returns HTTP errors 4xx or 5xxx |
| `HttpNotFoundException`          | Extends `HttpException` to handle specifically HTTP 404 exceptions                   |
| `NetworkException`               | The server could not be reached or the request could not be sent                     |
| `UnexpectedApiResponseException` | The distant API returned an unexpected or invalid response                           |

# Contribution

## Testing & Code Analysis

The provided Dockerfile and docker-compose can be used to trigger `phpunit` and `phpstan` with a text and html code
coverage report generation.

Execute with the following command:

``` bash
docker-compose run --rm domain-user
```
