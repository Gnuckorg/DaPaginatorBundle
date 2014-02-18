<?php

namespace Da\PaginatorBundle\PagerAdapter\Adapter;

use Pagerfanta\Exception\InvalidArgumentException;
use Pagerfanta\Adapter\AdapterInterface;

/**
 * @author Thomas Prelot <thomas.prelot@gmail.com>
 */
class AdvancedCallbackAdapter implements AdapterInterface
{
    private $getNbResultsCallback;
    private $getNbResultsCallbackParameters;
    private $getSliceCallback;
    private $getSliceCallbackParameters;

    /**
     * @param callable $getNbResultsCallback
     * @param array $getNbResultsCallbackParameters
     * @param callable $getSliceCallback
     * @param array $getSliceCallbackParameters
     */
    public function __construct(
        $getNbResultsCallback,
        array $getNbResultsCallbackParameters,
        $getSliceCallback,
        array $getSliceCallbackParameters
    )
    {
        if (!is_callable($getNbResultsCallback)) {
            throw new InvalidArgumentException('$getNbResultsCallback should be a callable');
        }
        if (!is_callable($getSliceCallback)) {
            throw new InvalidArgumentException('$getSliceCallback should be a callable');
        }

        $this->getNbResultsCallback = $getNbResultsCallback;
        $this->getNbResultsCallbackParameters = $getNbResultsCallbackParameters;
        $this->getSliceCallback = $getSliceCallback;
        $this->getSliceCallbackParameters = $getSliceCallbackParameters;
    }

    /**
     * {@inheritdoc}
     */
    public function getNbResults()
    {
        return call_user_func_array($this->getNbResultsCallback, $this->getNbResultsCallbackParameters);
    }

    /**
     * {@inheritdoc}
     */
    public function getSlice($offset, $length)
    {
        $this->getSliceCallbackParameters[] = $offset;
        $this->getSliceCallbackParameters[] = $length;

        return call_user_func_array($this->getSliceCallback, $this->getSliceCallbackParameters);
    }
}
