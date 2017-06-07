<?php

return [
    'name' => 'Contact',
    'description' => 'Contact resource',
    'model' => \Despark\Cms\ContactUs\Models\Contact::class,
    'controller' => \Despark\Cms\ContactUs\Http\Controller\ContactsController::class,
    'adminColumns' => [
        'type',
    ],
    'actions' => ['edit', 'create', 'destroy'],
    'adminFormFields' => [
        'type' => [
            'type' => 'select',
            'label' => 'Type',
            'sourceModel' => \Despark\Cms\ContactUs\Sources\Contacts::class,
        ],
        'content' => [
            'type' => 'textarea',
            'label' => 'Content',
        ],
    ],
    'adminMenu' => [
        'contact_management' => [
            'name' => 'Contacts Management',
            'iconClass' => 'fa-envelope-open-o',
        ],
        'contacts' => [
            'name' => 'Contacts',
            'link' => 'contact.index',
            'parent' => 'contact_management',
        ],
    ],
];
