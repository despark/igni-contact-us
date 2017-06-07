<?php

namespace Despark\Cms\ContactUs\Sources;

use Despark\Cms\ContactUs\Models\Contact;
use Despark\Cms\Contracts\SourceModel;

/**
 * Class Contacts.
 */
class Contacts implements SourceModel
{
    /**
     * @var array
     */
    protected $options;

    /**
     * @return array
     */
    public function toOptionsArray()
    {
        if (! isset($this->options)) {
            $contact = Contact::first();
            $type = \DB::select(\DB::raw("SELECT column_type FROM information_schema.columns WHERE table_name = '{$contact->getTable()}' AND column_name = 'type'"))[0]->column_type;
            preg_match('/^enum\((.*)\)$/', $type, $matches);

            foreach (explode(',', $matches[1]) as $value) {
                $v = trim($value, "'");
                $this->options = array_add($this->options, $v, $v);
            }
        }

        return $this->options;
    }
}
