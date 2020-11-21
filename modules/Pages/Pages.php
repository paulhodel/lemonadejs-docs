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
        // Get request route
        $route = implode('/', Render::$urlParam);

        // Get associate pages from the JSON
        $page = $this->service->getPage($route);

        // If a page is found
        if ($page) {
            $page['author'] = 'Paul Hodel';
            $this->setTitle($page['title']);
            $this->setDescription($page['description']);
            $this->setKeywords($page['keywords']);
            $this->setAuthor($page['author']);

            // View
            $view = isset($page['view']) && $page['view'] ? $page['view'] : $route;
        }

        // Try to find the view
        if (! isset($view)) {
            if ($this->getParam(2)) {
                $view = $this->getParam(1) . '/' . $this->getParam(2);
            } else {
                $view = $this->getParam(1);
            }
        }

        // Pages
        $this->view['pages'] = $this->service->getPages();
        $this->setView($view);
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
