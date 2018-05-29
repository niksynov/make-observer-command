[![Total Downloads](https://poser.pugx.org/nicksynev/make-observer-command/downloads.png)](https://packagist.org/packages/nicksynev/make-observer-command)
[![Latest Stable Version](https://poser.pugx.org/nicksynev/make-observer-command/v/stable.svg)](https://packagist.org/packages/nicksynev/make-observer-command)
[![License](https://poser.pugx.org/nicksynev/make-observer-command/license.svg)](https://packagist.org/packages/nicksynev/make-observer-command)

# make-observer-command
Artisan command for creating observer classes in Laravel.
## Installation
Install package via **composer**.

```bash
$ composer require nicksynev/make-observer-command
```
**(Only for Laravel 5.4 and below)** Add service provider into your **app.php** file in **config** folder.
```php
NickSynev\MakeObserverCommand\MakeObserverCommandServiceProvider::class,
```
## Usage
To add observer class you need to enter name, relative model's namespace and methods(optional). It will create Observers folder (if you dont have one) in your app directory and put class there. Also supports **subfolder structure** (for example User/UserObserver).
```bash
$ php artisan make:observer UserObserver 'App\Models\User' --methods=created,updated
```
There are 6 methods: **creating, created, updating, updated, deleting, deleted**.

If no method chosen puts all of them to a class.

Do not forget to init your observer for example in **AppServiceProvider** boot method.

```php
public function boot()
{
    User::observe(UserObserver::class);
    // Your code
}
```
## Removal
First remove service provider from **app.php**, then simply type by composer: 
```bash
$ composer remove nicksynev/make-observer-command
```
