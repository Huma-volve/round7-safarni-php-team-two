<?php
// config/menu.php

return [

    /*
    |--------------------------------------------------------------------------
    | Sidebar Menu Configuration
    |--------------------------------------------------------------------------
    |
    | Each item:
    | - 'route' => named route OR url (if 'external' => true)
    | - 'label' => translation key or plain string
    | - 'icon'  => css class for icon (optional)
    | - 'role'  => string role required to see item (optional)
    | - 'permission' => ability name for Gate::allows / $user->can() (optional)
    | - 'children' => array of sub-items (optional)
    | - 'badge' => ['text'=> 'New', 'class'=>'bg-danger'] optional
    |
    */

    [
        'route' => '/',
        'label' => 'Dashboards',
        'icon' => 'ri ri-home-smile-line',
    ],
    [
        'route' => 'admins',
        'label' => 'Admins & Roles',
        'icon' => 'ri ri-user-3-line',
        'permission' => 'view-admins',
        'children' => [
            [
                'route' => 'admins.index',
                'label' => 'All Admins',
                // 'permission' => 'view-admins',
                'icon' => 'ri ri-user-3-line',

            ],
            [
                'route' => 'roles.index',
                'label' => 'Roles',
                // 'permission' => 'view-roles',
                'icon' => 'ri ri-user-3-line',

            ],

        ],
    ],

    // [
    //     'route' => 'bookings.index',
    //     'label' => 'Bookings',
    //     'icon' => 'ri ri-calendar-2-line',
    //     'permission' => 'view-bookings',
    //     'badge' => ['text' => '3', 'class' => 'badge bg-label-danger rounded-pill ms-2']
    // ],
    // [
    //     'route' => 'questions.index',
    //     'label' => 'Questions',
    //     'icon' => 'ri ri-question-line',
    //     'permission' => 'view-bookings',
    //     // 'badge' => ['text' => '3', 'class' => 'badge bg-label-danger rounded-pill ms-2']
    // ],
    // [
    //     'route' => 'settings.index',
    //     'label' => 'Settings',
    //     'icon' => 'ri ri-settings-4-line',
    //     'permission' => 'view-bookings',
    //     // 'badge' => ['text' => '3', 'class' => 'badge bg-label-danger rounded-pill ms-2']
    // ],


    /*
    [
        'route' => 'reviews.index',
        'label' => 'Reviews',
        'icon' => 'ri ri-star-line',
        'permission' => 'view-reviews',
    ],

    [
        'route' => 'users.index',
        'label' => 'Users',
        'icon' => 'ri ri-group-line',
        'role' => 'admin', // only admin can see
        'children' => [
            [
                'route' => 'users.index',
                'label' => 'All Users',
                'permission' => 'view-users',
            ],
            [
                'route' => 'admin.broadcast',
                'label' => 'Broadcast',
                'permission' => 'send-admin-broadcast',
            ],
        ],
    ],

    [
        'route' => 'settings.index',
        'label' => 'Settings',
        'icon' => 'ri ri-settings-4-line',
        'role' => 'admin',
    ],
*/
];
