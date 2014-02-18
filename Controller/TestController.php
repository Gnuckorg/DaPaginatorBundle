<?php

namespace Da\PaginatorBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class TestController extends ContainerAware
{
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
                array('id' => 1,  'name' => 'Madrid',    'desc' => 'none'),
                array('id' => 2,  'name' => 'Berlin',    'desc' => 'none'),
                array('id' => 3,  'name' => 'London',    'desc' => 'none'),
                array('id' => 4,  'name' => 'Boston',    'desc' => 'none'),
                array('id' => 5,  'name' => 'Chicago',   'desc' => 'none'),
                array('id' => 6,  'name' => 'New York',  'desc' => 'none'),
                array('id' => 7,  'name' => 'Sidney',    'desc' => 'none'),
                array('id' => 8,  'name' => 'Paris',     'desc' => 'none'),
                array('id' => 9,  'name' => 'Tokyo',     'desc' => 'none'),
                array('id' => 10, 'name' => 'Hong Kong', 'desc' => 'none'),
                array('id' => 11, 'name' => 'Pekin',     'desc' => 'none'),
                array('id' => 12, 'name' => 'Bombay',    'desc' => 'none')
            )),
            $skip,
            $limit,
            'skip',
            'limit'
        );

        $paginator->definePaginatedContentView('big_cities', 'names', array('id' => 'Id', 'name' => 'City Name'));

        return array();
    }
}
