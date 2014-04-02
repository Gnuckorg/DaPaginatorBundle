Basic Uusage
============

Paginated content definition
----------------------------

Let's take a simple example:

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

Like it is explained in the overview, you first have to define a paginated content then a view (or many) on this content.
Here is an explanation on the argments of these two methods in this example:

`defineOffsetPaginatedContent`:
* The first argument is the fields/columns to display. The key is the property or key of the data and the value is the displayed (or translated) name of the field.
* 'array' is the id of the [adapter](adapters.md) to handle the data.
* The third argument is the data. In fact, these are the arguments to pass to the adapter constructor in an array form.
* 'skip' is the name of the offset parameter in the querystring.
* 'limit' is the name of the length parameter in the querystring.

You can use a page/per_page pattern instead of the offset/length one with the method `definePerPagePaginatedContent` which works the same as `defineOffsetPaginatedContent`.

Paginated content display
-------------------------

To display a paginated content, just use this method:

```twig
{{ da_paginator.render(cities, 'bootstrap')|raw }}
```

`renderContentView`:
* cities is the paginated content.
* 'bootstrap' is the id of the [view](views.md) to use for the rendering.