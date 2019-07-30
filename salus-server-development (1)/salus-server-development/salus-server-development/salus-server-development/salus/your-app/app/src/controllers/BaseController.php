<?php

namespace App\Controller;

use Slim\Container;
class BaseController
{
    protected $view;
    protected $logger;
    protected $flash;
    protected $router;
    protected $db;

    public function __construct(Container $c)
    {
        $this->view = $c->get('view');
        $this->logger = $c->get('logger');
        $this->flash = $c->get('flash');
        $this->router = $c->get('router');
        $this->db = $c->get('db');
    }
}