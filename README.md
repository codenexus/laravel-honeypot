Honeypot spam prevention for Laravel applications
=========

## Compatibility

Laravel 5.3

## How does it work? 

"Honeypot" method of spam prevention is a simple and effective way to defer some of the spam bots that come to your site. This technique is based on creating an input field that should be left empty by the real users of the application but will most likely be filled out by spam bots. 

This package creates two hidden input fields, honeypot field (like "my_name") and a honeytime field - an encrypted timestamp that marks the moment when the page was served to the user. When the form containing these inputs invisible to the user is submitted to your application, a custom validator that comes with the package checks that the honeypot field is empty and also checks the time it took for the user to fill out the form. If the form was filled out too quickly (i.e. less than 5 seconds) or if there was a value put in the honeypot field, this submission is most likely from a spam bot.

## Installation:

In your terminal type : `composer require codenexus/laravel-honeypot` and provide "dev-master" as the version of the package. Or open up composer.json and add the following line under "require":

```php
"require": {
    "codenexus/laravel-honeypot": "dev-master"
}
```

Next, add this line to 'providers' section of the app config file in `app/config/app.php`:

```php
/*
 * Package Service Providers...
 */

...
Codenexus\Honeypot\HoneypotServiceProvider::class,
```

Add the honeypot facade to 'aliases':

```php
...
'Honeypot' => Codenexus\Honeypot\Facades\Honeypot::class,
```

At this point the package is installed and you can use it as follows.

## Usage :

Add the honeypot catcher to your form by inserting `Honeypot::fill(..)` like this: 

`{!! Honeypot::fill('my_name', 'my_time'); !!}`  

The `fill` method will output the following HTML markup (`my_time` field will contain an encrypted timestamp):
    
```php
<input type="hidden" id="my_name" name="my_name" value="">
<input type="hidden" name="my_time" value="eyJpdiI6IkxoeWhKc3prN2puZllEajRwZ3lrc0I5bU42bUFWbzF1NEVVOEhxbG9WcFE9IiwidmFsdWUiOiJxNEtBT0NpYW5lUjJvWXp6VE45a1U0V3dNbk9Jd2RUNW42NFpiQWtTRllRPSIsIm1hYyI6IjAyMWQ0NWI1NTVkYTBjZTAxMTdhZmJmNTY0ZDI4Nzg4NzU3ODU4MjM1Y2MxNTVkYjAwNmFhNzBmNTdlNmJmMjkifQ==">
```

After adding the honeypot fields in the markup with the specified macro add the validation for the honeypot and honeytime fields of the form: 

```php
$this->validate($request, [
    ...
    'my_name' => 'honeypot',
    'my_time' => 'required|honeytime:5'
]);
```

Please note that "honeytime" takes a parameter specifying number of seconds it should take for the user to fill out the form. If it takes less time than that the form is considered a spam submission.

That's it! Enjoy getting less spam in your inbox.

## Credits

Based on work originally created by Ian Landsman: <https://github.com/ianlandsman/Honeypot> as well as the remake by Maks Surguy: <https://github.com/msurguy/Honeypot>