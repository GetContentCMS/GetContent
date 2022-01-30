<?php

namespace GetContent\CMS\Editor\Navigation;

use Illuminate\Support\Collection;

class Nav
{
    protected array $items = [];

    /**
     * @param  string  $name
     * @return NavItem
     */
    public function create(string $name): NavItem
    {
        $item = (new NavItem)->name($name);

        $this->items[] = $item;

        return $item;
    }

    /**
     * @return Collection
     */
    public function items(): Collection
    {
        return collect($this->items);
    }
}
