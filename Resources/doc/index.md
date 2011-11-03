SyliusPluginsBundle documentation.
=====================================

Prototype version of bundle that add plugins feature to any Symfony2 application.
You can manage plugins through a simple and customizable web interface.
It is something like Styles in phpBB.
Stay tuned and [follow me on twitter](http://twitter.com/pjedrzejewski) for updates.
Have a nice read, and remember that it still lacks some of the important features.

Thanks [@lsmith77](http://github.com/lsmith77) and [@stof](http://github.com/stof) for idea of integrating the bundles!
The bundle extends from the awesome [LiipPluginBundle](http://github.com/liip/LiipPluginBundle).

**Note!** This documentation is inspired by [FOSUserBundle docs](https://github.com/FriendsOfSymfony/FOSUserBundle/blob/master/Resources/doc/index.md).

Installation.
-------------

+ Installing dependencies.
+ Downloading the bundle.
+ Autoloader configuration.
+ Adding bundle to kernel.
+ DIC configuration.
+ Importing routing cfgs.
+ Updating database schema.
+ Testing.
+ Creating plugin.
+ The pattern of locating files.

### Installing depdencies.

You need to first install the [LiipPluginBundle](http://github.com/liip/LiipPluginBundle).

### Downloading the bundle.

The good practice is to download the bundle to the `vendor/bundles/Sylius/Bundle/PluginsBundle` directory.

This can be done in several ways, depending on your preference. The first
method is the standard Symfony2 method.

**Using the vendors script.**

Add the following lines in your `deps` file...

```
[SyliusPluginsBundle]
    git=git://github.com/Sylius/SyliusPluginsBundle.git
    target=bundles/Sylius/Bundle/PluginsBundle
```

Now, run the vendors script to download the bundle.

``` bash
$ php bin/vendors install
```

**Using submodules.**

If you prefer instead to use git submodules, the run the following:

``` bash
$ git submodule add git://github.com/Sylius/SyliusPluginsBundle.git vendor/bundles/Sylius/Bundle/PluginsBundle
$ git submodule update --init
```

### Autoloader configuration.

Add the `Sylius\Bundle` namespace to your autoloader.

``` php
<?php
// app/autoload.php

$loader->registerNamespaces(array(
    // ...
    'Sylius\\Bundle' => __DIR__.'/../vendor/bundles',
));
```

### Adding bundle to kernel.

Finally, enable the bundle in the kernel.

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Sylius\Bundle\PluginsBundle\SyliusPluginsBundle(),
    );
}
```

### Container configuration.

Now you have to do the minimal configuration, no worries, it is not painful.

Open up your `config.yml` file and add this...

``` yaml
sylius_plugins:
    driver: ORM
    classes:
        model:
            plugin: Sylius\Bundle\PluginsBundle\Entity\Plugin
```

`Please note, that the "ORM" is currently the only supported driver.`

### Import routing files.

Now is the time to import routing files. Open up your `routing.yml` file. Customize the prefixes or whatever you want.
If you want to use static plugin resolver import just the second one, otherwise import both files.

``` yaml
sylius_plugins_plugin:
    resource: "@SyliusPluginsBundle/Resources/config/routing/frontend/plugin.yml"

sylius_plugins_backend_plugin:
    resource: "@SyliusPluginsBundle/Resources/config/routing/backend/plugin.yml"
    prefix: /administration
```

### Updating database schema.

The last thing you need to do is updating the database schema.

For "ORM" driver run the following command.

``` bash
$ php app/console doctrine:schema:update --force
```

### Testing.

Now if you want to test the bundle, use the two sample plugins. They are located in...

`Resources/fixtures`

Copy both `PluginA` and `PluginB` to the plugins directory.
Now go to `/administration/plugins` and install both of them.
You can switch between them by activating the desired plugin.
If you can see the difference, the bundle is working properly.

**Note!** The dynamic resolver might not be working properly as I am still modifying it.

### Creating plugin.

`Will be written soon.`

### The pattern of locating files.

First the locator looks into kernel dir, where you can override any resource files. Just like in pure Symfony2.

Second, the locator looks in the following path.

```
{The directory where plugins are stored}/{Active plugin path}/{Bundle name}
```

If the file is not present it just looks into the bundle.

`This documentation is under construction.`
