[![Latest Stable Version](https://poser.pugx.org/femtopixel/nano-framework/v/stable)](https://packagist.org/packages/femtopixel/nano-framework) 
[![Build status](https://travis-ci.org/femtopixel/nano-framework.svg)](https://travis-ci.org/femtopixel/nano-framework)
[![Code Climate](https://codeclimate.com/github/femtopixel/nano-framework/badges/gpa.svg)](https://codeclimate.com/github/femtopixel/nano-framework)
[![License](https://poser.pugx.org/femtopixel/nano-framework/license)](https://packagist.org/packages/femtopixel/nano-framework)

# Nano Framework
easier than easiest things

# Installation

```
composer require femtopixel/nano-framework
```

## Bootstrap

all your request can be redirected to your bootstrap (assuming index.php)

```php
<?php
require_once ('vendor/autoload.php');
(new \Nano\Framework())->dispatch();
```

That's all!

# How it works?

With that on, you can now access to your pages like this :

http://mysite.tld/ \<controller>/\<action>

And it will load the class \Project\Controller\\\<controller>::\<action>Action

You can easily configure your namespace, controller package and action suffix!

Either \<controller> or \<action> are optional and considered as 'index' if not defined.

Therefore

url | class::method
--- | -------------
http://mysite.tld/ | \Project\Controller\Index::indexAction
http://mysite.tld/test | \Project\Controller\Test::indexAction
http://mysite.tld/test/action | \Project\Controller\Test::actionAction
