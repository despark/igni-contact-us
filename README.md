## About
This package extends [despark/igni-core](https://github.com/despark/igni-core) by adding a fully working Contacts Page consisting of:
  1. Tables for contact details and messages.
  2. Resources
  3. Routes
  4. Config
  5. Contact form
  6. Email notifications
  7. Helpers

## Installation
Get it from composer
```bash
composer require despark/igni-contact-us
```

Add our service provider to `config/app.php`
```php
$providers = [
    ...
    Despark\Cms\ContactUs\Providers\IgniContactUsServiceProvider::class,
]
```

Run install command
```bash
php artisan igni:make:contacts
```

## Take a quick look at ignicontacts config file
```php
return [
    'google_api_key' => env('GOOGLE_MAPS_API_KEY', null),
    // Send an email to the first one in contacts table when a new message is submitted. true||false||null
    'recieve_email_notifications' => true,
    'mail_receiver_name' => 'Example',
    'mail_subject' => 'New message was received',
    'path_to_email_view' => 'emails.newMessage',
];
```

A new Contacts Management sidebar will be added to the CMS page

## We made some helpers so that you can quickly check the functionality of this package and build further more
```php

class HomeController extends Controller {
    // Show a contact form example
    public function showForm(){
        igniContactForm();
    }

    // Shows all contact details
    public function showContactDetails(){
        igniContactDetails();
    }

    // Shows a contact map
    public function showContactMap(){
        igniContactMap();
    }

    // Shows all of the above
    public function showFullContactPage(){
        igniFullContactPage();
    }
}

```
