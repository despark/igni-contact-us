<?php

namespace Despark\Cms\ContactUs\Http\Controllers;

use Despark\Cms\ContactUs\Http\Requests\ContactFormRequest;
use Despark\Cms\ContactUs\Models\Contact;
use Despark\Cms\ContactUs\Models\ContactMessage;
use Despark\Cms\Http\Controllers\AdminController;

class ContactMessagesController extends AdminController
{
    public function submit(ContactFormRequest $request)
    {
        $input = $request->all();

        $contactMessage = ContactMessage::create($input);

        $this->sendEmail($contactMessage);

        return redirect()->back()->with('message', 'Your message was submitted successfully!');
    }

    protected function sendEmail($contactMessage)
    {
        $emailContact = Contact::whereType('email')->first();
        if ($emailContact && config('ignicontacts.recieve_email_notifications')) {
            \Mail::send(config('ignicontacts.path_to_email_view'), ['emailContact' => $emailContact, 'contactMessage' => $contactMessage],
                function ($message) use ($emailContact) {
                    $message->to($emailContact->content, config('ignicontacts.mail_receiver_name'))->subject(config('ignicontacts.mail_subject'));
                }
            );
        }
    }
}
