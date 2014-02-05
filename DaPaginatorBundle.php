<?php

namespace Da\PaginatorBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Da\PaginatorBundle\DependencyInjection\DaPaginatorExtension;

class DaPaginatorBundle extends Bundle
{
    public function __construct()
    {
        $this->extension = new DaPaginatorExtension();
    }
}
