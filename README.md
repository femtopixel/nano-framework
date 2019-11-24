![logo](logo.png)

Nano Framework
==============

[![Build Status](https://scrutinizer-ci.com/g/femtopixel/nano-framework/badges/build.png?b=master)](https://scrutinizer-ci.com/g/femtopixel/nano-framework/build-status/master)
[![Latest Stable Version](https://poser.pugx.org/femtopixel/nano-framework/v/stable)](https://packagist.org/packages/femtopixel/nano-framework) 
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.0-8892BF.svg?style=flat-square)](https://php.net/)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/femtopixel/nano-framework/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/femtopixel/nano-framework/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/femtopixel/nano-framework/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/femtopixel/nano-framework/?branch=master)
[![License](https://poser.pugx.org/femtopixel/nano-framework/license)](https://packagist.org/packages/femtopixel/nano-framework)
[![Bitcoin donation](https://github.com/jaymoulin/jaymoulin.github.io/raw/master/btc.png "Bitcoin donation")](https://m.freewallet.org/id/374ad82e/btc)
[![Litecoin donation](https://github.com/jaymoulin/jaymoulin.github.io/raw/master/ltc.png "Litecoin donation")](https://m.freewallet.org/id/374ad82e/ltc)
[![Watch Ads](https://github.com/jaymoulin/jaymoulin.github.io/raw/master/utip.png "Watch Ads")](https://utip.io/femtopixel)
[![PayPal donation](https://github.com/jaymoulin/jaymoulin.github.io/raw/master/ppl.png "PayPal donation")](https://www.paypal.me/jaymoulin)
[![Buy me a coffee](https://www.buymeacoffee.com/assets/img/custom_images/orange_img.png "Buy me a coffee")](https://www.buymeacoffee.com/3Yu8ajd7W)

Nano is a simple stupid framework, really easy to handle, and really efficient.

It only implements the C part (Controller) of the MVC design pattern which allows developers to use any other existing library for others parts

Installation
---

    composer require femtopixel/nano-framework

Bootstrap
---

all your request can be redirected to your bootstrap (assuming index.php)

```php
<?php
require_once ('vendor/autoload.php');
$nano = new \Nano\Framework();
$nano->dispatch();
```

That's all!

How it works?
---

With that on, you can now access to your pages like this :

http://mysite.tld/ \<controller>/\<action>

And it will load the class \Project\Controller\\\<controller>::\<method>\<action>Action

You can easily configure your namespace, controller package and action suffix!

*\<method>* represents the HTTP method used (usually *get* but you can use post/update/delete etc...). This is optional.

Either \<controller> or \<action> are optional and considered as 'index' if not defined.

Therefore

url                                            | class::method
---------------------------------------------- | ---------------------------------------
http://mysite.tld/                             | \Project\Controller\Index::indexAction
http://mysite.tld/test                         | \Project\Controller\Test::indexAction
http://mysite.tld/test/action                  | \Project\Controller\Test::actionAction
http://mysite.tld/also/work/with/full/path     | \Project\Controller\Also\Work\With\Full::pathAction
http://mysite.tld/my/normal                    | \Project\Controller\My::getNormalAction
http://mysite.tld/my/normal (with HTTP post)   | \Project\Controller\My::postNormalAction

## Parameter Matching

Since 0.6.0, you can use *"Parameter Matching"*

Simply activate it when dispatching :

```php
require_once ('vendor/autoload.php');
$nano = new \Nano\Framework();
$nano->setParameterMatching()->dispatch();
``` 

And then you'll be able to use it like this :

```php
<?php
namespace \Project\Controller;

class MyAwesomeController
{
    public function getHelloAction($age, $name)
    {
        echo "Hello $name, I'm {$age}yo"; //please, use this code for test only
    }
}
```

and call `http://mysite.tld/myawesomecontroller/hello?name=World&age=900` to display "Hello World, I'm 900yo" !
