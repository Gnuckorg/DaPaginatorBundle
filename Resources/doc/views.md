Views
=====

Role
----

The role of a view is to customize the display of your paginated content.

Creation of a new one
---------------------

First, you have to define a new renderer class:

```php
namespace My\OwnBundle\View\Renderer;

use Pagerfanta\View\DefaultView;

class MyPaginationRenderer extends AbstractRenderer
{
    /**
     * Get the template name.
     *
     * @return string The template name.
     */
    protected function getTemplateName()
    {
        return 'MyOwnBundle::myPagination.html.twig';
    }

    /**
     * {@inheritdoc}
     */
    protected function getPaginationView()
    {
        return new DefaultView();
    }
}
```

Then, declare it as a service in your bundle:

```yml
services:
    # ...

    my_own.renderer.my_pagination:
        class: My\OwnBundle\View\Renderer\MyPaginationRenderer
        arguments: [@templating, @translator]
        tags:
            - { name: da_paginator.renderer, id: my_pagination }
```

To display a paginated content with it, just use this method in your twig:

```twig
{{ da_paginator.renderContentView('big_cities', 'names', 'my_pagination')|raw }}
```