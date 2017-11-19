# make-observer-command
Make observer command for laravel 
## Installation
First as far as this functionality is in dev mode you need to add this to your **composer.json** file
```json
"minimum-stability": "dev",
"prefer-stable": true
```
Next install package Via Composer

```bash
$ composer require composer require nicksynev/make-observer-command
```
Then add service provider into your **app.php** file in **config** folder
```php
JeroenG\Packager\PackagerServiceProvider::class,
```
To add Observer class you need to enter Observer name and relative model which need to be observed. It will create Observers folder (if you dont have one) in your app directory and put class there.
```bash
$ php artisan make:observer UserObserver 'App\Models\User' --methods=created,updated
```
There are 6 methods in command

```creating, created, updating, updated, deleting, deleted```

If no method chosen randomly puts all of them to class
