<?php

namespace Despark\Cms\ContactUs\Models;

use Despark\Cms\Models\AdminModel;

class Contact extends AdminModel
{
    protected $table = 'contacts';

    protected $fillable = [
        'type',
        'content',
    ];

    protected $rules = [
        'type' => 'required|in:telephone,email,address,fax,skype,facebook,twitter,google+,instagram',
        'content' => 'required|max:255',
    ];

    protected $identifier = 'contact';
}
