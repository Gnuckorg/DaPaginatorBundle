DaPaginatorBundle
=================

This Symfony2's bundle is an helper for managing paginated contents in an easy way. It is built on [Pagerfanta](https://github.com/whiteoctober/Pagerfanta).


Installation
------------

Installation is a quick 2 steps process.

### Step 1: Add in composer

Add the bundle in the composer.json file:

```json
// composer.json

"require": {
    // ...
    "pagerfanta/pagerfanta": "dev-master",
    "da/paginator-bundle": "dev-master"
},
```

Update your vendors with composer:

```sh
composer update      # WIN
composer.phar update # LINUX
```

### Step 2: Declare in the kernel

Declare the bundle in your kernel:

```php
// app/AppKernel.php

$bundles = array(
    // ...
    new Da\PaginatorBundle\DaPaginatorBundle(),
);
```


Usage
-----

### Paginated content definition

```php
/**
 * @Route("/")
 * @Template()
 */
public function testAction()
{
    $paginator = $this->container->get('da_paginator.paginator');

    $paginatedContent = $paginator->defineOffsetPaginatedContent(
        array('id' => 'Id', 'name' => 'City Name'),
        'array',
        array(array(
            array('id' => 1,  'name' => 'madrid',    'desc' => 'none'),
            array('id' => 2,  'name' => 'berlin',    'desc' => 'none'),
            array('id' => 3,  'name' => 'london',    'desc' => 'none'),
            array('id' => 4,  'name' => 'boston',    'desc' => 'none'),
            array('id' => 5,  'name' => 'chicago',   'desc' => 'none'),
            array('id' => 6,  'name' => 'new york',  'desc' => 'none'),
            array('id' => 7,  'name' => 'sidney',    'desc' => 'none'),
            array('id' => 8,  'name' => 'paris',     'desc' => 'none'),
            array('id' => 9,  'name' => 'tokyo',     'desc' => 'none'),
            array('id' => 10, 'name' => 'hong kong', 'desc' => 'none'),
            array('id' => 11, 'name' => 'pekin',     'desc' => 'none'),
            array('id' => 12, 'name' => 'bombay',    'desc' => 'none')
        )),
        'skip',
        'limit'
    );

    return array('cities' => $paginatedContent);
}
```

`defineOffsetPaginatedContent` allows you to define a paginated content. `array` means you use a data in an array form but you can use a doctrine query builder, callbacks and many others.

You can use an offset/length pattern or a page/per_page pattern and define your own labels (here skip/limit).

### Paginated content display

```twig
{{ da_paginator.render(cities, 'bootstrap')|raw }}
```

`render` allows you to render a paginated content in a fast and customized way.


Documentation
-------------

You can do a lot more things like formatting the content of a column.
Let's take a look at the full [documentation](https://github.com/Gnuckorg/DaPaginatorBundle/blob/master/Resources/doc/index.md) to have more explanations and see advanced features!