Laravel Binput
==============

Laravel Binput was created by, and is maintained by [Graham Campbell](https://github.com/GrahamCampbell), and is an input protector for [Laravel](https://laravel.com/) that prevents potentially dangerous elements like `<script>` tags in any input you receive, from doing harm. It utilises my [Laravel Security](https://github.com/GrahamCampbell/Laravel-Security) package, which cleans the input using [voku/anti-xss](https://github.com/voku/anti-xss). Feel free to check out the [change log](CHANGELOG.md), [releases](https://github.com/GrahamCampbell/Laravel-Binput/releases), [security policy](https://github.com/GrahamCampbell/Laravel-Binput/security/policy), [license](LICENSE), [code of conduct](.github/CODE_OF_CONDUCT.md), and [contribution guidelines](.github/CONTRIBUTING.md).

![Banner](https://user-images.githubusercontent.com/2829600/71477342-6000a000-27e1-11ea-93d0-1ee413a31ab1.png)

<p align="center">
<a href="https://github.com/GrahamCampbell/Laravel-Binput/actions?query=workflow%3ATests"><img src="https://img.shields.io/github/actions/workflow/status/GrahamCampbell/Laravel-Binput/tests.yml?label=Tests&style=flat-square" alt="Build Status"></img></a>
<a href="https://github.styleci.io/repos/12090308"><img src="https://github.styleci.io/repos/12090308/shield" alt="StyleCI Status"></img></a>
<a href="LICENSE"><img src="https://img.shields.io/badge/license-MIT-brightgreen?style=flat-square" alt="Software License"></img></a>
<a href="https://packagist.org/packages/graham-campbell/binput"><img src="https://img.shields.io/packagist/dt/graham-campbell/binput?style=flat-square" alt="Packagist Downloads"></img></a>
<a href="https://github.com/GrahamCampbell/Laravel-Binput/releases"><img src="https://img.shields.io/github/release/GrahamCampbell/Laravel-Binput?style=flat-square" alt="Latest Version"></img></a>
</p>


## Installation

This version requires [PHP](https://www.php.net/) 8.0-8.3 and supports [Laravel](https://laravel.com/) 9-10.

| Binput | L5.5               | L5.6               | L5.7               | L5.8               | L6                 | L7                 | L8                 | L9                 | L10                |
|--------|--------------------|--------------------|--------------------|--------------------|--------------------|--------------------|--------------------|--------------------|--------------------|
| 5.1    | :white_check_mark: | :white_check_mark: | :white_check_mark: | :x:                | :x:                | :x:                | :x:                | :x:                | :x:                |
| 6.2    | :white_check_mark: | :white_check_mark: | :white_check_mark: | :white_check_mark: | :white_check_mark: | :x:                | :x:                | :x:                | :x:                |
| 7.1    | :white_check_mark: | :white_check_mark: | :white_check_mark: | :white_check_mark: | :white_check_mark: | :white_check_mark: | :x:                | :x:                | :x:                |
| 8.0    | :x:                | :x:                | :x:                | :x:                | :white_check_mark: | :white_check_mark: | :x:                | :x:                | :x:                |
| 9.1    | :x:                | :x:                | :x:                | :x:                | :white_check_mark: | :white_check_mark: | :white_check_mark: | :white_check_mark: | :x:                |
| 10.0   | :x:                | :x:                | :x:                | :x:                | :x:                | :x:                | :white_check_mark: | :white_check_mark: | :x:                |
| 11.0   | :x:                | :x:                | :x:                | :x:                | :x:                | :x:                | :x:                | :white_check_mark: | :white_check_mark: |

To get the latest version, simply require the project using [Composer](https://getcomposer.org/):

```bash
$ composer require "graham-campbell/binput:^11.0"
```

Once installed, if you are not using automatic package discovery, then you need to register the `GrahamCampbell\Security\SecurityServiceProvider` and `GrahamCampbell\Binput\BinputServiceProvider` service providers in your `config/app.php`.

You can also optionally alias our facade:

```php
        'Binput' => GrahamCampbell\Binput\Facades\Binput::class,
```


## Configuration

Laravel Binput requires no configuration. Just follow the simple install instructions and go!


## Usage

##### Binput

This is the class of most interest. It is bound to the ioc container as `'binput'` and can be accessed using the `Facades\Binput` facade. There are a few public methods of interest.

The `'all'`, `'get'`, `'input'`, `'only'`, `'except'`, and `'old'` methods have an identical api to the methods found on the laravel request class accept from they all accept two extra parameters at the end. The first extra parameter is a boolean representing if the input should be trimmed. The second extra parameter is a boolean representing if the input should be xss cleaned. Both extra parameters are default to true.

There are two additional methods added to the public api. The first is a method called `'map'` which will remap the output from the `'only'` method. The `'map'` function requires an associative array as the first parameter. The second method is the `'clean'` function. It takes three parameters. The first is the value to be cleaned (it can be an array, and will be recursively iterated over and cleaned), and the final two are trim and clean, which behave in the same way as earlier.

Any methods not found on this binput class will actually fall back to the laravel request class with a dynamic call function, so every other method on the request class is available in exactly the same way it would be on the Laravel request class.

##### Facades\Binput

This facade will dynamically pass static method calls to the `'binput'` object in the ioc container which by default is the `Binput` class.

##### BinputServiceProvider

This class contains no public methods of interest. This class should be added to the providers array in `config/app.php`. This class will setup ioc bindings.


##### Real Examples

Here you can see an example of just how simple this package is to use.

```php
// request input data: ['test' => '123', 'foo' => '<script>alert(\'bar\');</script>    ']

$input = Binput::all(); // ['test' => '123', 'foo' => '']
```


## Security

If you discover a security vulnerability within this package, please send an email to security@tidelift.com. All security vulnerabilities will be promptly addressed. You may view our full security policy [here](https://github.com/GrahamCampbell/Laravel-Binput/security/policy).


## License

Laravel Binput is licensed under [The MIT License (MIT)](LICENSE).


## For Enterprise

Available as part of the Tidelift Subscription

The maintainers of `graham-campbell/binput` and thousands of other packages are working with Tidelift to deliver commercial support and maintenance for the open source dependencies you use to build your applications. Save time, reduce risk, and improve code health, while paying the maintainers of the exact dependencies you use. [Learn more.](https://tidelift.com/subscription/pkg/packagist-graham-campbell-binput?utm_source=packagist-graham-campbell-binput&utm_medium=referral&utm_campaign=enterprise&utm_term=repo)
