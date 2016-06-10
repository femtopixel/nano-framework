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

http://mysite.tld/<controller>/<action>

And it will load the class \Project\Controller\<controller>::<action>Action

You can easily configure your namespace, controller package and action suffix!

Either <controller> or <action> are optionnal and considered as 'index' if not defined.

Therefore

url | class::method
--- | -------------
http://mysite.tld/ | \Project\Controller\Index::indexAction
http://mysite.tld/test | \Project\Controller\Test::indexAction
http://mysite.tld/test/action | \Project\Controller\Test::actionAction
