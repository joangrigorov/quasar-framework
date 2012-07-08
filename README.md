### Welcome to Galanthus Framework

# About

Galanthus Framework is open-source, dependency injection based web application MVC framework. It's implemented in PHP 5.3.

Galanthus Framework is inspired by both [Zend Framework](http://framework.zend.com) and [Konstrukt](http://konstrukt.dk)

The dependency injection container (galanthus\di) is based on a project, known as [Phemto](http://phemto.sourceforge.net). Nevertheless Phemto was refactored, many bugs were fixed and many new features were added. 

# Configuration

## How to setup Galanthus Framework?

Setting up Galanthus is trivial easy, just clone the repository into your server root directory

```
$ cd /home/user/path/to/server/root
$ git clone git://github.com/sasquatch-mc/galanthus-framework.git
```
or download the tarball/zip package and extract it.

# Quickstart

Using Galanthus is very easy.

## Testing the new installation

After you get Galanthus, you can test it by navigating your browser to the public_html/ directory(e.g. http://localhost/galanthus-framework/public_html). A welcome page with the Galanthus Framework logo should appear.

In the examples below we will use a virtual host ([http://galanthus.localhost](http://galanthus.localhost)) which will point to public_html

## Galanthus controllers

Unlike Zend Framework, controllers here are not action controllers (with dispatchable methods). Here we use only one method (execute()) to invoke controller's functionality. The default (index) controller in Galanthus is named 'Root' and It's placed in **src/app/controllers/Root.php**

Example:

**src/app/controllers/My.php**:
```php
<?php

namespace app\controllers;

use galanthus\controller\Controller;

class My extends Controller
{

    public function execute()
    {
        $this->response->message = 'Hello world!';
    }

}
```

We need a view script for this controller:

**src/app/views/templates/my.phtml**:
```php
<h2>This is my first controller!</h2>
<hr />
<?=$this->message?>
```

And we are done! You can acces this controller by refering to [http://galanthus.localhost/my](http://galanthus.localhost/my)

## Nested controllers

Galanthus implements something that I call **nested controllers**. This means that one controller can forward to another. 
For example if I create a controller named 'Settings', and place it in src\app\controllers**\my\Settings.php** I'll be able to access it by refering to [http://galanthus.localhost/my/settings](http://galanthus.localhost/my/settings). In order to make the 'Settings' controller available, 'My' controller also has to exist.

What Galanthus does is that when the request is created the requested controllers are chained and invoked one after another. You can nest how many controllers as you want to whatever depth you want.
