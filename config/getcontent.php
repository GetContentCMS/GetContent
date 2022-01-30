<?php

// config for GetContent/GetContent
return [

    /*
     * --------------------------------------------------------------------------
     * Enable Routes
     * --------------------------------------------------------------------------
     * GetContent adds its own routes to front-end of your site.
     * Turn this off if you'd rather handle it yourself.
     * */
    'routes_enabled' => env('GETCONTENT_ROUTES_ENABLED', true),

    /*
     * --------------------------------------------------------------------------
     * GetContent Editor
     * --------------------------------------------------------------------------
     * Choose if you want the default editor
     * enabled and the route to load it on
     * */
    'editor_enabled' => env('GETCONTENT_EDITOR_ENABLED', true),
    'editor_route' => env('GETCONTENT_EDITOR_ROUTE', 'editor'),
];
