# Laravel API Response Helpers

Helpers to send API always in one JSON format:

```json
{
  "message": "User has been successfully deleted",
  "data": {
    "id": "1",
    "name": "Lazizbek"
  }
}
```

## Install

## Installation

Simply require the package via composer into your Laravel API.

    composer require lazerg/laravel-response-helpers

After that require the trait `\lazerg\LaravelResponseHelpers\ResponseHelpers` inside of your main controller `app/Http/Controllers/Controller.php`;