[![Latest Stable Version](https://poser.pugx.org/femtopixel/nano-framework/v/stable)](https://packagist.org/packages/femtopixel/nano-framework) 
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%205.3-8892BF.svg?style=flat-square)](https://php.net/)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.0-8892BF.svg?style=flat-square)](https://php.net/)
[![Build status](https://travis-ci.org/femtopixel/nano-framework.svg)](https://travis-ci.org/femtopixel/nano-framework)
[![Code Climate](https://codeclimate.com/github/femtopixel/nano-framework/badges/gpa.svg)](https://codeclimate.com/github/femtopixel/nano-framework)
[![Test Coverage](https://codeclimate.com/github/femtopixel/nano-framework/badges/coverage.svg)](https://codeclimate.com/github/femtopixel/nano-framework/coverage)
[![Issue Count](https://codeclimate.com/github/femtopixel/nano-framework/badges/issue_count.svg)](https://codeclimate.com/github/femtopixel/nano-framework)
[![Dependency Status](https://www.versioneye.com/user/projects/575f150d7757a0004a1df17f/badge.svg?style=flat)](https://www.versioneye.com/user/projects/575f150d7757a0004a1df17f)
[![License](https://poser.pugx.org/femtopixel/nano-framework/license)](https://packagist.org/packages/femtopixel/nano-framework)


Nano Framework
===
Nano is a simple stupid framework, really easy to handle, and really performant.

It implements the MVC design pattern

Installation
---

    composer require femtopixel/nano-framework

Bootstrap
---

all your request can be redirected to your bootstrap (assuming index.php)

```php
<?php
require_once ('vendor/autoload.php');
(new \Nano\Framework())->dispatch();
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

url                           | class::method
----------------------------- | ---------------------------------------
http://mysite.tld/            | \Project\Controller\Index::indexAction
http://mysite.tld/test        | \Project\Controller\Test::indexAction
http://mysite.tld/test/action | \Project\Controller\Test::actionAction
