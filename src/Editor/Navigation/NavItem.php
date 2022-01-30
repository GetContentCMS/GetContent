<?php

namespace GetContent\CMS\Editor\Navigation;

use Illuminate\Support\Facades\Request;
use Str;

class NavItem
{
    protected $name;
    protected $url;
    protected $route;
    protected $icon;
    protected $active;

    /**
     * Get or set name.
     *
     * @param  string|null  $name
     * @return NavItem|string
     */
    public function name(string $name = null)
    {
        if (!$name) {
            return $this->name;
        }

        $this->name = $name;
        return $this;
    }

    /**
     * @param  string|null  $url
     * @return NavItem|string
     */
    public function url(string $url = null)
    {
        if (!$url) {
            return $this->url;
        }

        $this->url = !Str::of($url)->startsWith('http') ? url($url) : $url;
        return $this;
    }

    /**
     * @param  string|null  $route
     * @return NavItem|string
     */
    public function route(string $route = null)
    {
        if (!$route) {
            return blank($this->route) ? null : route($this->route);
        }

        $this->route = $route;
        return $this;
    }

    /**
     * @param  string|null  $icon
     * @return NavItem|string
     */
    public function icon(string $icon = null)
    {
        if (!$icon) {
            return $this->icon;
        }

        $this->icon = $icon;
        return $this;
    }

    /**
     * @param  string|null  $active
     * @return NavItem|string
     */
    public function active(string $active = null)
    {
        if (!$active) {
            return $this->active;
        }

        $this->active = $active;
        return $this;
    }

    public function isCurrent()
    {
        return Str::of(Request::url())->startsWith($this->route() ?? $this->url());
    }
}
