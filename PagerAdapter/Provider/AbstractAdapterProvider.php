<?php

namespace Da\PaginatorBundle\PagerAdapter\Provider;

/**
 * Abstract helper for provider.
 *
 * @author Thomas Prelot <tprelot@gmail.com>
 */
abstract class AbstractAdapterProvider implements PagerAdapterProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(array $arguments = array())
    {
        $class = new \ReflectionClass($this->getAdapterClassName());

        return $class->newInstanceArgs($arguments);
    }

    /**
     * Get the class name of the adapter.
     *
     * @return string The class name of the adapter.
     */
    abstract protected function getAdapterClassName();
}