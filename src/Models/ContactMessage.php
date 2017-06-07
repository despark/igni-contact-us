<?php

namespace Despark\Cms\ContactUs\Models;

use Despark\Cms\Models\AdminModel;

class ContactMessage extends AdminModel
{
    protected $table = 'contact_messages';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'message',
    ];

    protected $rules = [
        'name' => 'required|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'required|max:50',
        'message' => 'required',
    ];

    protected $identifier = 'contactMessage';
}
