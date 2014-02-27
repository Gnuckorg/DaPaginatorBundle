Column Customization
====================

You can customize the display of a column in a simple and secure way (handle XSS, ...).

Let's take the previous example:

```php
/**
 * @Route("/")
 * @Template()
 */
public function testAction()
{
    $query = $this->container->get('request')->query;
    $skip = $query->get('skip', 0);
    $limit = $query->get('limit', 5);

    $paginator = $this->container->get('da_paginator.paginator');

    $paginator->defineOffsetPaginatedContent(
        'big_cities',
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
        $skip,
        $limit,
        'skip',
        'limit'
    );

    $paginator->definePaginatedContentView(
        'big_cities',
        'names',
        array('id' => 'Id', 'name' => 'City Name')
    );

    // ADDED
    $paginator->setContentFieldMacro(
        'big_cities',
        'names',
        'DaPaginatorBundle:Test:macros.html.twig'
    );

    return array();
}
```

`setContentFieldMacro`:
* 'big_cities' is the id of the paginated content.
* 'names' is the id of the view.
* 'DaPaginatorBundle:Test:macros.html.twig' is the logical name of the file defining macros.

Here is the content of the macros' file:

```twig
{% macro name(item, value) %}
    {{ value|title }}
{% endmacro %}
```

The name of the macro should be the name of the column you want to customize. Here, we want to uppercase the first letters of the name of the cities. Of course, you can define as many macro as you want. This system help you to handle XSS in a Symfony standard way.