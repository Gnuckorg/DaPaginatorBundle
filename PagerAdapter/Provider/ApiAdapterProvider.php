<?php

namespace Da\PaginatorBundle\PagerAdapter\Provider;

/**
 * Provider for api adapter.
 *
 * @author Thomas Prelot <tprelot@gmail.com>
 */
class ApiAdapterProvider implements PagerAdapterProviderInterface
{
    /**
     * The API clients.
     *
     * @var array
     */
    protected $apiClients;

    /**
     * {@inheritdoc}
     */
    public function create(array $arguments = array(), $offsetLabel, $limitLabel, $isPerPagePattern)
    {
        $class = new \ReflectionClass($this->getAdapterClassName());

        $adapter = $class->newInstanceArgs('Da\PaginatorBundle\PagerAdapter\Adapter\ApiAdapter');

        $apiName = $arguments[0];

        if (!isset($this->apiClients[$apiName])) {
            throw new LogicException(sprintf(
                'API "%s" is not a configurated API.',
                $apiName
            ));
        }

        $adapter
            ->setApiClient($this->apiClients[$apiName])
            ->setParameters($offsetLabel, $limitLabel, $isPerPagePattern)
        }

        return $adapter;
    }

    /**
     * Set an API client.
     *
     * @param string                                               $name      The unique name of the API.
     * @param \Da\ApiClientBundle\Http\Rest\RestApiClientInterface $apiClient The API client.
     */
    public function setApiClient($name, $apiClient)
    {
        $this->apiClients[$name] = $apiClient;
    }
}