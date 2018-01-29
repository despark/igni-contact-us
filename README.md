<p align="center"><img src="https://despark.com/public/images/despark-logo.svg"></p>

<p align="center">
<a href="https://packagist.org/packages/despark/igni-contact-us"><img src="https://poser.pugx.org/despark/igni-contact-us/v/stable.svg" alt="Latest Stable Version"></a>
</p>

# Despark's igniCMS Contact Us Module
## About
This package extends [despark/igni-core](https://github.com/despark/igni-core) by adding a fully functional Contacts Page consisting of:
  1. DB tables for contact details and messages.
  2. Resources
  3. Routes
  4. Config
  5. Contact form
  6. Email notifications
  7. Helpers

## Installation
Require using [Composer](https://getcomposer.org)
```bash
composer require despark/igni-contact-us
```

Add the service provider to `config/app.php`
```php
$providers = [
    ...
    Despark\Cms\ContactUs\Providers\IgniContactUsServiceProvider::class,
]
```

Run the artisan install command
```bash
php artisan igni:make:contacts
```

A new Contacts Management sidebar will be added to the CMS page

## Take a quick look at ignicontacts config file
```php
return [
    'google_api_key' => env('GOOGLE_MAPS_API_KEY', null),
    // Send an email to the first email address in contacts table when a new message is submitted. true||false||null
    'recieve_email_notifications' => true,
    'mail_receiver_name' => 'Example',
    'mail_subject' => 'New message was received',
    'path_to_email_view' => 'emails.newMessage',
];
```

## We made some helpers so that you can quickly visualise the main sections of a standard Contacts page and build further more
```php
igniContactForm()
```
Outputs a contact form with simpl HTML structure
<br/><br/>

```php
igniContactDetails()
```
Outputs all the cotact details using simple HTML structure
<br/><br/>

```php
igniContactMap()
```
Outputs Google Maps JS map focused on the address you've setup in the contacts
<br/><br/>

```php
igniFullContactPage()
```
Output a fully fledged Contact Us page with all contact details, contact form and map
