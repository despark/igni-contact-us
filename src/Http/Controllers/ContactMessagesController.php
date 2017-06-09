<?php

namespace Despark\Cms\ContactUs\Http\Controllers;

use Despark\Cms\ContactUs\Http\Requests\ContactFormRequest;
use Despark\Cms\ContactUs\Models\ContactMessage;
use Despark\Cms\Http\Controllers\AdminController;

class ContactMessagesController extends AdminController
{
    public function submit(ContactFormRequest $request)
    {
        $input = $request->all();

        $contactMessage = ContactMessage::create($input);

        return redirect()->back();
    }
}
