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

Nothing change here.

```twig
{{ da_paginator.render(cities, 'bootstrap', 'DaPaginatorBundle:Test:macros.html.twig')|raw }}
```

When you call the rendering method, you can give a macro path like this one.
Here is the example of the content of this file:

```twig
{% macro name(item, value) %}
    {{ value|title }}
{% endmacro %}
```

The name of the macro should be the name of the field/column to customize. Here, it will uppercase the first letters of the name of the cities. Of course, it is possible to define as many macro as needed. This system help you to handle XSS in a Symfony standard way.