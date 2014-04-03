<?php

namespace Da\PaginatorBundle\PagerAdapter\Adapter;

use Pagerfanta\Exception\InvalidArgumentException;
use Pagerfanta\Adapter\AdapterInterface;
use Da\ApiClientBundle\Http\Rest\RestApiClientInterface;

/**
 * Adpater for DaApiClient.
 *
 * @author Thomas Prelot <thomas.prelot@gmail.com>
 */
class ApiAdapter implements AdapterInterface
{
    /**
     * The name of the API.
     *
     * @var string
     */
    private $apiName;

    /**
     * The path of the get url.
     *
     * @var string
     */
    private $getPath;
    
    /**
     * The path of the count url.
     *
     * @var string
     */
    private $countPath;

    /**
     * The query string.
     *
     * @var array
     */
    private $queryString;

    /**
     * The optional headers.
     *
     * @var array
     */
    private $headers;

    /**
     * Whether or not using cache.
     *
     * @var boolean
     */
    private $noCache;

    /**
     * The label for the pagination offset.
     *
     * @var string
     */
    private $offsetLabel;
    
    /**
     * The label for the pagination limit.
     *
     * @var string
     */
    private $limitLabel;

    /**
     * Whether or not it is a per page pattern (not an offset limit one).
     *
     * @var boolean
     */
    private $isPerPagePattern;

    /**
     * The API client.
     *
     * @var RestApiClientInterface
     */
    private $apiClient;

    /**
     * Constructor.
     *
     * @param string  $apiName          The name of the API.
     * @param string  $getPath          The path of the get url.
     * @param string  $countPath        The path of the count url.
     * @param array   $queryString      The query string.
     */
    public function __construct(
        $apiName,
        $getPath,
        $countPath,
        array $queryString = array(),
        array $headers = array(),
        $noCache = false
    )
    {
        $this->apiName = $apiName;
        $this->getPath = $getPath;
        $this->countPath = $countPath;
        $this->queryString = $queryString;
        $this->headers = $headers;
        $this->noCache = $noCache;
    }

    /**
     * Set an API client.
     *
     * @param string  $offsetLabel      The label for the pagination offset.
     * @param string  $limitLabel       The label for the pagination limit.
     * @param boolean $isPerPagePattern Whether or not it is a per page pattern (not an offset limit one).
     *
     * @return ApiAdapter This.
     */
    public function setApiClient(
        $offsetLabel = 'offset',
        $limitLabel = 'limit',
        $isPerPagePattern = false
    )
    {
        $this->offsetLabel = $offsetLabel;
        $this->limitLabel = $limitLabel;
        $this->isPerPagePattern = $isPerPagePattern;

        return $this;
    }

    /**
     * Set the API client.
     *
     * @param RestApiClientInterface $apiClient The API client.
     *
     * @return ApiAdapter This.
     */
    public function setApiClient(RestApiClientInterface $apiClient)
    {
        $this->apiClient = $apiClient;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getNbResults()
    {
        $response = $this->apiClient->get($this->countPath, $queryString, $headers, $noCache);
        $count = -1;

        if (!is_numeric($response)) {
            // JSON.
            $json = json_decode($response);

            if (null !== $json) {
                $count = $this->findCount($json);
            } else {
                // PHP serialization.
                $unserialization = @unserialize($response);

                if (false !== $unserialization) {
                    $count = $this->findCount($unserialization);
                }
            }
        } else {
            $count = (int)$response;
        }

        if (-1 === $count) {
            throw new LogicException(sprintf(
                'Cannot find the count in the response "%s" of the webservice "%s" of the api "%s".',
                $response,
                $this->countPath,
                $this->apiName
            ));
        }

        return $count;
    }

    /**
     * Find a count in a response.
     *
     * @param array|numeric The response.
     *
     * @return integer The count or -1 if not found.
     */
    private function findCount($response)
    {
        if (is_array($json)) {
            if (isset($json['count']) && is_numeric($json['count'])) {
                return (int)$json['count'];
            }
        } else if (is_numeric($json)) {
            return (int)$json;
        }

        return -1;
    }

    /**
     * {@inheritdoc}
     */
    public function getSlice($offset, $length)
    {
        if ($this->isPerPagePattern) {
            $offset = floor($offset / $length) + 1;
        }

        $queryString = array_merge(
            $this->queryString,
            array(
                $offsetLabel => $offset,
                $limitLabel => $length
            )
        );

        $response = $this->apiClient->get($this->getPath, $queryString, $headers, $noCache);

        // JSON.
        $json = json_decode($response);

        if (null !== $json && is_array($json)) {
            return $json;
        }

        // PHP serialization.
        $unserialization = @unserialize($response);

        if (false !== $unserialization && is_array($unserialization)) {
            return $unserialization;
        }

        throw new LogicException(sprintf(
            'Cannot find the results in the response "%s" of the webservice "%s" of the api "%s".',
            $response,
            $this->getPath,
            $this->apiName
        ));
    }
}
