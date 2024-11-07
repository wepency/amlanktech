<?php

return [
    'dashboard' => [
        'tag' => 'li',
        'href' => 'home',
        'class' => 'side-item side-item-category',
        'content' => 'لوحة التحكم',
        'icon' => '',
        'who_can_view' => 'admin',
    ],
    'site' => [
        'tag' => 'li',
        'href' => 'home',
        'class' => 'side-item side-item-category',
        'content' => 'أملاك-تك',
        'icon' => '',
        'who_can_view' => 'admin',
    ],

    'associations-category' => [
        'tag' => 'li',
        'href' => 'home',
        'class' => 'side-item side-item-category',
        'content' => 'الجمعيات',
        'icon' => '',
        'who_can_view' => 'admin',

        'items' => [

            'associations-parent' => [
                'tag' => 'li',
                'href' => 'dashboard.users.index',
                'class' => 'side-item',
                'content' => 'الجمعيات',
                'icon' => '',
                'who_can_view' => 'admin',

                'items' => [

                    'associations-sub' => [
                        'tag' => 'li',
                        'href' => 'dashboard.users.index',
                        'class' => 'side-item',
                        'content' => 'الجمعيات',
                        'icon' => '',
                        'who_can_view' => 'admin',
                    ],

                    'units' => [
                        'tag' => 'li',
                        'href' => 'dashboard.users.index',
                        'class' => 'side-item',
                        'content' => 'الجمعيات',
                        'icon' => '',
                        'who_can_view' => 'admin',
                    ],

                ]
            ],
        ]
    ],
];
