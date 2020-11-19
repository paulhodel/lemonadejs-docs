<?php

namespace modules\Pages;

use bossanova\Module\Module;
use bossanova\Render\Render;

class Pages extends Module
{
    public function __construct()
    {
        $this->service = new \services\Pages($this->version);

        // Module name
        $module_name = strtolower(Render::$configuration['module_name']);

        $area = new \stdClass;
        $area->template_area = 'top';
        $area->module_name = $module_name;
        $area->method_name = 'top';
        $this->setContent($area);

        $area = new \stdClass;
        $area->template_area = 'menu';
        $area->module_name = $module_name;
        $area->method_name = 'menu';
        $this->setContent($area);

        $area = new \stdClass;
        $area->template_area = 'logo';
        $area->module_name = $module_name;
        $area->method_name = 'logo';
        $this->setContent($area);

        parent::__construct();
    }

    public function __default()
    {
        $route = [];
        if ($this->getParam(0)) $route[] = $this->getParam(0);
        if ($this->getParam(1)) $route[] = $this->getParam(1);
        if ($this->getParam(2)) $route[] = $this->getParam(2);
        if ($this->getParam(3)) $route[] = $this->getParam(3);
        $route = implode('/', $route);
        $page = $this->service->getPage($route);
        if ($page) {
            $page['author'] = 'Paul Hodel';
            $this->setTitle($page['title']);
            $this->setDescription($page['description']);
            $this->setKeywords($page['keywords']);
            $this->setAuthor($page['author']);

            $route = [];
            if ($this->getParam(1)) $route[] = $this->getParam(1);
            if ($this->getParam(2)) $route[] = $this->getParam(2);
            if ($this->getParam(3)) $route[] = $this->getParam(3);
            $route = implode('/', $route);

            $view = isset($page['view']) && $page['view'] ? $page['view'] : $route;
            if ($index = $this->getIndex($view)) {
                $this->view['index'] = $index;
            }
            // Pages
            $this->view['pages'] = $this->service->getPages();
            $this->setView($view);
        }
    }

    public function logo()
    {
        return $this->loadView('logo', $this->version);
    }

    public function top()
    {
        return $this->loadView('top', $this->version);
    }

    public function menu()
    {
        $this->view = $this->service->getPages();

        $html = $this->loadView('menu', $this->version);

        return $html;
    }
}
