Laravel Binput
==============

Laravel Binput was created by, and is maintained by [Graham Campbell](https://github.com/GrahamCampbell), and is an input protector for [Laravel 5](http://laravel.com) that prevents potentially dangerous elements like `<script>` tags in any input you receive, from doing harm. It utilises my [Laravel Security](https://github.com/GrahamCampbell/Laravel-Security) package. 

Feel free to check out the [change log](CHANGELOG.md), [releases](https://github.com/GrahamCampbell/Laravel-Binput/releases), [license](LICENSE), and [contribution guidelines](CONTRIBUTING.md).

![Laravel Binput](https://cloud.githubusercontent.com/assets/2829600/4432294/c1133286-468c-11e4-801e-6f589ad9cd37.PNG)

<p align="center">
<a href="https://styleci.io/repos/12090308"><img src="https://styleci.io/repos/12090308/shield" alt="StyleCI Status"></img></a>
<a href="https://travis-ci.org/GrahamCampbell/Laravel-Binput"><img src="https://img.shields.io/travis/GrahamCampbell/Laravel-Binput/master.svg?style=flat-square" alt="Build Status"></img></a>
<a href="https://scrutinizer-ci.com/g/GrahamCampbell/Laravel-Binput/code-structure"><img src="https://img.shields.io/scrutinizer/coverage/g/GrahamCampbell/Laravel-Binput.svg?style=flat-square" alt="Coverage Status"></img></a>
<a href="https://scrutinizer-ci.com/g/GrahamCampbell/Laravel-Binput"><img src="https://img.shields.io/scrutinizer/g/GrahamCampbell/Laravel-Binput.svg?style=flat-square" alt="Quality Score"></img></a>
<a href="LICENSE"><img src="https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square" alt="Software License"></img></a>
<a href="https://github.com/GrahamCampbell/Laravel-Binput/releases"><img src="https://img.shields.io/github/release/GrahamCampbell/Laravel-Binput.svg?style=flat-square" alt="Latest Version"></img></a>
</p>


## Installation

Either [PHP](https://php.net) 5.5+ or [HHVM](http://hhvm.com) 3.6+ are required.

To get the latest version of Laravel Binput, simply require the project using [Composer](https://getcomposer.org):

```bash
$ composer require graham-campbell/binput
```

Instead, you may of course manually update your require block and run `composer update` if you so choose:

```json
{
    "require": {
        "graham-campbell/binput": "^3.0"
    }
}
```

You will need to register the [Laravel Security](https://github.com/GrahamCampbell/Laravel-Security) service provider before you attempt to load the Laravel Binput service provider. Open up `config/app.php` and add the following to the `providers` key.

* `'GrahamCampbell\Security\SecurityServiceProvider'`

Once Laravel Binput is installed, you need to register the service provider. Open up `config/app.php` and add the following to the `providers` key.

* `'GrahamCampbell\Binput\BinputServiceProvider'`

You can register the Binput facade in the `aliases` key of your `config/app.php` file if you like.

* `'Binput' => 'GrahamCampbell\Binput\Facades\Binput'`


## Configuration

Laravel Binput requires no configuration. Just follow the simple install instructions and go!


## Usage

##### Binput

This is the class of most interest. It is bound to the ioc container as `'binput'` and can be accessed using the `Facades\Binput` facade. There are a few public methods of interest.

The `'all'`, `'get'`, `'input'`, `'only'`, `'except'`, and `'old'` methods have an identical api to the methods found on the laravel request class accept from they all accept two extra parameters at the end. The first extra parameter is a boolean representing if the input should be trimmed. The second extra parameter is a boolean representing if the input should be xss cleaned. Both extra parameters are default to true.

```php
// request input data: 'test' => '123', 'foo' => '<script>alert(\'bar\');</script>    '

$input = Binput::all(); // 'test' => '123', 'foo' => '[removed]alert&#40;\'bar\'&#41;;[removed]'

```

There are two additional methods added to the public api. The first is a method called `'map'` which will remap the output from the `'only'` method. The `'map'` function requires an associative array as the first parameter. The second method is the `'clean'` function. It takes three parameters. The first is the value to be cleaned (it can be an array, and will be recursively iterated over and cleaned), and the final two are trim and clean, which behave in the same way as earlier.

Any methods not found on this binput class will actually fall back to the laravel request class with a dynamic call function, so every other method on the request class is available in exactly the same way it would be on the Laravel request class.

##### Facades\Binput

This facade will dynamically pass static method calls to the `'binput'` object in the ioc container which by default is the `Binput` class.

##### BinputServiceProvider

This class contains no public methods of interest. This class should be added to the providers array in `config/app.php`. This class will setup ioc bindings.


## Security

If you discover a security vulnerability within this package, please send an e-mail to Graham Campbell at graham@alt-three.com. All security vulnerabilities will be promptly addressed.


## License

Laravel Binput is licensed under [The MIT License (MIT)](LICENSE).
