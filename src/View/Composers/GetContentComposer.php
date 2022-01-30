<?php

namespace GetContent\CMS\View\Composers;

use GetContent\CMS\Facades\Nav;
use Illuminate\View\View;

class GetContentComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view): void
    {
        $view
            ->with('GetContent', app('GetContent'))
            ->with('nav', Nav::items());
    }
}
