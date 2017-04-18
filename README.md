[![Latest Stable Version](https://poser.pugx.org/femtopixel/crop/v/stable)](https://packagist.org/packages/femtopixel/nano-framework) 
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.0-8892BF.svg?style=flat-square)](https://php.net/)
[![Build Status](https://scrutinizer-ci.com/g/femtopixel/nano-framework/badges/build.png?b=master)](https://scrutinizer-ci.com/g/femtopixel/nano-framework/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/femtopixel/nano-framework/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/femtopixel/nano-framework/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/femtopixel/nano-framework/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/femtopixel/nano-framework/?branch=master)
[![License](https://poser.pugx.org/femtopixel/nano-framework/license)](https://packagist.org/packages/femtopixel/nano-framework)

Nano Framework
===
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

And it will load the class \Project\Controller\\\<controller>::\<action>Action

You can easily configure your namespace, controller package and action suffix!

Either \<controller> or \<action> are optional and considered as 'index' if not defined.

Therefore

url                                        | class::method
------------------------------------------ | ---------------------------------------
http://mysite.tld/                         | \Project\Controller\Index::indexAction
http://mysite.tld/test                     | \Project\Controller\Test::indexAction
http://mysite.tld/test/action              | \Project\Controller\Test::actionAction
http://mysite.tld/also/work/with/full/path | \Project\Controller\Also\Work\With\Full::pathAction
