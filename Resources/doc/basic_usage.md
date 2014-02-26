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

    return array();
}
```

Like it is explained in the overview, you first have to define a paginated content then a view (or many) on this content.
Here is an explanation on the argments of these two methods in this example:

`defineOffsetPaginatedContent`:
* 'big_cities' is the id of the paginated content.
* 'array' is the id of the [adapter](adapters.md) to handle the data.
* The third argument is the data. In fact, these are the arguments to pass to the adapter constructor in an array form.
* '$skip' is the number of rows to skip in the data.
* '$limit' is the number of rows to retrieve.
* 'skip' is the name of the offset parameter in the querystring.
* 'limit' is the name of the length parameter in the querystring.

`definePaginatedContentView`:
* 'big_cities' is the id of the paginated content.
* 'names' is the id of the view.
* The third argument is the an array with the name of the properties in key and the displayed names in value. You can specify non-existent keys to display additional [custom columns](column_customization.md).

You can use a page/per_page pattern instead of the offset/length one with the method `definePerPagePaginatedContent` which works the same as `defineOffsetPaginatedContent`.

Paginated content display
-------------------------

To display a paginated content, just use this method:

```twig
{{ da.paginator.renderContentView('big_cities', 'names', 'bootstrap')|raw }}
```

`renderContentView`:
* 'big_cities' is the id of the paginated content.
* 'names' is the id of the view.
* 'bootstrap' is the id of the [view](views.md) to use for the rendering.