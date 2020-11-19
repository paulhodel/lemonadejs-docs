<?php

namespace services;

use bossanova\Services\Services;

class Pages extends Services
{
    public function __construct($file)
    {
        $pages = file_get_contents('resources/' . $file . '.json');
        $pages = json_decode($pages, true);
        $this->pages = [];
        foreach ($pages as $v) {
            $this->pages[$v['url']] = $v;
        }
    }

    public function getPage($v)
    {
        return isset($this->pages[$v]) ? $this->pages[$v] : null;
    }

    public function getPages()
    {
        return $this->pages;
    }

    public function getPagesByCategory($category)
    {
        $data = [];

        foreach ($this->pages as $v) {
            if (isset($v['category']) && $v['category'] == $category) {
                $data[] = $v;
            }
        }

        return $data;
    }
}