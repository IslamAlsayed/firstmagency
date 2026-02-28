<?php

use Illuminate\Support\Str;

return [
    'menu' => [
        [
            'title' => 'dashboard',
            'icon' => 'fas fa-gauge',
            'route' => null,
        ],

        // ================= Subscriptions =================
        // [
        //     'title' => 'subscriptions',
        //     'icon' => 'fas fa-box',
        //     'children' => [
        //         [
        //             'title' => 'my modules',
        //             'icon' => 'fas fa-puzzle-piece',
        //             'route' => null,
        //         ],
        //         [
        //             'title' => 'all subscriptions',
        //             'icon' => 'fas fa-list-check',
        //             'route' => null,
        //         ],
        //     ],
        // ],

        // ================= Core - النظام =================
        [
            'title' => 'core',
            'icon' => 'fas fa-gear',
            'status' => 'done',
            'label' => 'system',
            'children' => [
                // ================= Users - المستخدمين =================
                [
                    'title' => 'users',
                    'icon' => 'fas fa-users-gear',
                    'children' => [
                        [
                            'title' => 'all users',
                            'icon' => 'fas fa-users',
                            'route' => null,
                        ],
                        [
                            'title' => 'create user',
                            'icon' => 'fas fa-user-plus',
                            'route' => null,
                        ],
                        // [
                        //     'title' => 'import users',
                        //     'icon' => 'fas fa-file-import',
                        //     'route' => null,
                        //     'parameters' => ['model' => 'user', 'models' => 'users', 'view' => 'users'],
                        // ]
                    ],
                ],
                // ================= Roles & Permissions - الأدوار والصلاحيات =================
                [
                    'title' => 'roles_and_permissions',
                    'icon' => 'fas fa-shield',
                    'status' => 'new',
                    'children' => [
                        [
                            'title' => 'roles',
                            'icon' => 'fas fa-crown',
                            'route' => null,
                        ],
                        [
                            'title' => 'create role',
                            'icon' => 'fas fa-square-plus',
                            'route' => null,
                        ],
                        [
                            'title' => 'permissions',
                            'icon' => 'fas fa-lock',
                            'route' => null,
                        ],
                        [
                            'title' => 'create permission',
                            'icon' => 'fas fa-square-plus',
                            'route' => null,
                        ],
                        [
                            'title' => 'role requests',
                            'status' => 'new',
                            'icon' => 'fas fa-clock',
                            'route' => null,
                        ]
                    ],
                ],
                // ================= Reports & Analytics - التقارير والتحليلات =================
                [
                    'title' => 'reports & analytics',
                    'icon' => 'fas fa-chart-pie',
                    'children' => [
                        [
                            'title' => 'reports dashboard',
                            'icon' => 'fas fa-gauge',
                            'route' => null,
                        ],
                        [
                            'title' => 'user reports',
                            'icon' => 'fas fa-user-chart',
                            'route' => null,
                        ],
                        [
                            'title' => 'location reports',
                            'icon' => 'fas fa-map-marked',
                            'route' => null,
                        ],
                        [
                            'title' => 'detailed analytics',
                            'icon' => 'fas fa-chart-line',
                            'route' => null,
                        ],
                    ],
                ],
                // ================= Topics - المواضيع =================
                [
                    'title' => 'pricing definitions',
                    'icon' => 'fas fa-money-bill-wave',
                    'children' => [
                        [
                            'title' => 'all pricing definitions',
                            'icon' => 'fas fa-list',
                            'route' => null,
                        ],
                        [
                            'title' => 'create pricing definition',
                            'icon' => 'fas fa-plus',
                            'route' => null,
                        ],
                    ],
                ],
                // ================= Notifications - الإشعارات =================
                // [
                //     'title' => 'notifications',
                //     'icon' => 'fas fa-bell',
                //     'route' => null,
                // ],
                // ================= Activity Log - سجل النشاط =================
                [
                    'title' => 'activity log',
                    'icon' => 'fas fa-clipboard-list',
                    'children' => [
                        [
                            'title' => 'all activities',
                            'icon' => 'fas fa-list',
                            'route' => null,
                            'parameters' => ['t' => Str::random(240), 'type' => ''],
                        ],
                        [
                            'title' => 'user activities',
                            'icon' => 'fas fa-user',
                            'route' => null,
                            'parameters' => ['t' => Str::random(240), 'type' => 'users'],
                        ],
                        [
                            'title' => 'system activities',
                            'icon' => 'fas fa-cogs',
                            'route' => null,
                            'parameters' => ['t' => Str::random(240), 'type' => 'system'],
                        ],
                    ],
                ],
                // ================= Profile - الملف الشخصي =================
                [
                    'title' => 'profile',
                    'icon' => 'fas fa-id-badge',
                    'children' => [
                        [
                            'title' => 'view profile',
                            'icon' => 'fas fa-circle-user',
                            'route' => null,
                        ],
                        [
                            'title' => 'edit profile',
                            'icon' => 'fas fa-pen-to-square',
                            'route' => null,
                        ],
                        [
                            'title' => 'change password',
                            'icon' => 'fas fa-key',
                            'route' => null,
                        ],
                    ],
                ],
                // ================= Settings - الإعدادات =================
                [
                    'title' => 'settings',
                    'icon' => 'fas fa-gear',
                    'children' => [
                        [
                            'title' => 'general',
                            'icon' => 'fas fa-sliders',
                            'route' => null,
                        ],
                        [
                            'title' => 'security',
                            'icon' => 'fas fa-shield-halved',
                            'route' => null,
                            'roles' => ['admin', 'superadmin']
                        ],
                        // [
                        //     'title' => 'notifications',
                        //     'route' => null,
                        // ],
                        [
                            'title' => 'backup',
                            'icon' => 'fas fa-database',
                            'fixed' => 'soon',
                            // 'route' => null,
                            // 'route' => null,
                        ],
                        [
                            'title' => 'booking',
                            'icon' => 'fas fa-book',
                            'fixed' => 'soon',
                            // 'route' => null,
                            // 'route' => null,
                        ],
                        [
                            'title' => 'integration',
                            'icon' => 'fas fa-plug',
                            'route' => null,
                            'roles' => ['admin', 'superadmin']
                        ],
                        [
                            'title' => 'system',
                            'icon' => 'fas fa-cog',
                            'route' => null,
                        ],
                    ],
                ],
            ],
        ],
    ],
];
