Adapters
========

Role
----

The role of an adapter is to provide a common interface in order to paginate different kind of data (simple array, doctrine requests, callbacks, ...).

Creation of a new one
---------------------

First, you have to define a new adapter class implementing `Pagerfanta\Adapter\AdapterInterface`. You can find many examples in the code of Pagerfanta or in this bundle.

Then, you must define a provider for this adapter:

```php
namespace My\OwnBundle\PagerAdapter\Provider;

class MyAdapterProvider extends AbstractAdapterProvider
{
    /**
     * {@inheritdoc}
     */
    protected function getAdapterClassName()
    {
        return 'My\OwnBundle\PagerAdapter\Adapter\MyAdapter';
    }
}
```

Then, declare it as a service in your bundle:

```yml
services:
    # ...

    my_own.pager_adapter_provider.my_adapter:
        class: My\OwnBundle\PagerAdapter\Provider\MyAdapterProvider
        arguments: []
        tags:
            - { name: da_paginator.pager_adapter_provider, id: my_adapter }
```

To use this adapter for a paginated content, do the following:

```php
$this->container->get('da_paginator.paginator')->defineOffsetPaginatedContent(
    'big_cities',
    'my_adapter',
    array(/* The arguments to pass to the constructor of your adapter */),
    $skip,
    $limit,
    'skip',
    'limit'
);
```