<?php

    return [
        'google_api_key' => env('GOOGLE_MAPS_API_KEY', null),
        // Send an email to the first one in contacts table when a new message is submitted. true||false||null
        'recieve_email_notifications' => true,
        'mail_receiver_name' => 'Example',
        'mail_subject' => 'New message was received',
        'path_to_email_view' => 'emails.newMessage',
    ];
