<?php

return [
    'name' => 'Contact Message',
    'description' => 'Contact Message resource',
    'model' => \Despark\Cms\ContactUs\Models\ContactMessage::class,
    'controller' => \Despark\Cms\ContactUs\Http\Controller\ContactMessagesController::class,
    'adminColumns' => [
        'name',
        'email',
        'phone',
        'submitted' => 'created_at',
    ],
    'actions' => ['edit', 'destroy'],
    'adminFormFields' => [
        'name' => [
            'type' => 'text',
            'label' => 'Name',
        ],
        'email' => [
            'type' => 'text',
            'label' => 'Email',
        ],
        'phone' => [
            'type' => 'text',
            'label' => 'Phone',
        ],
        'message' => [
            'type' => 'textarea',
            'label' => 'Message',
        ],
    ],
    'adminMenu' => [
        'contactMessages' => [
            'name' => 'Contact Messages',
            'link' => 'contactmessage.index',
            'parent' => 'contact_management',
        ],
    ],
];
