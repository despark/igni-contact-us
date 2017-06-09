<?php

if (! function_exists('igniContactForm')) {
    function igniContactForm()
    {
        $html = '
            <hr>
            <h1 style="text-align: center;">Contact Form</h1>
            <hr>
            <form action="'.route('form.submit').'" method="POST" style="text-align: center;">
                '.csrf_field().'
                <div>
                    <label for="name">Name</label>
                    <div>
                        <input type="text" name="name" value="'.old('name').'" required autofocus maxlength="255">
                    </div>
                </div>

                <div>
                    <label for="email">Email</label>
                    <div>
                        <input type="email" name="email" value="'.old('email').'" required maxlength="255">
                    </div>
                </div>

                <div>
                    <label for="phone">Phone</label>
                    <div>
                        <input type="text" name="phone" value="'.old('phone').'" required maxlength="50">
                    </div>
                </div>
                <div>
                    <label for="message">Message</label>
                    <div>
                        <textarea name="message" placeholder="Your message goes here...">'.old('message').'</textarea>
                    </div>
                </div>

                <div>
                    <button type="submit">
                        Submit
                    </button>
                </div>
            </form>';

        return $html;
    }
}

if (! function_exists('igniContactDetails')) {
    function igniContactDetails()
    {
        $contacts = Despark\Cms\ContactUs\Models\Contact::all();

        $html = '<hr>
                <h1 style="text-align: center;">Contact Details</h1>
                <hr>';

        foreach ($contacts as $contact) {
            $html .= '
                <div style="text-align: center;">
                    <label for="type">Type</label>
                    <div>
                        <p>'.$contact->type.'</p>
                    </div>
                </div>
                <div style="text-align: center;">
                    <label for="message">Content</label>
                    <div>
                        <p>'.$contact->content.'</p>
                    </div>
                </div>
                <hr>';
        }

        return $html;
    }
}

if (! function_exists('igniContactMap')) {
    function igniContactMap()
    {
        $html = '
            <hr>
            <h1 style="text-align: center;">Map</h1>
            <hr>
            <div id="map" style="width:400px;height:400px;background:yellow;margin-left:auto;margin-right:auto;"></div>
            <script>
            function myMap() {
            var mapOptions = {
                center: new google.maps.LatLng(51.5, -0.12),
                zoom: 1,
                mapTypeId: google.maps.MapTypeId.HYBRID
            }
            var map = new google.maps.Map(document.getElementById("map"), mapOptions);
            }
            </script>

            <script src="https://maps.googleapis.com/maps/api/js?key='.config('ignicontacts.google_api_key').'&callback=myMap"></script>';

        return $html;
    }
}

if (! function_exists('igniFullContactPage')) {
    function igniFullContactPage()
    {
        $html = igniContactDetails();
        $html .= config('ignicontacts.google_api_key') ? igniContactMap() : '';
        $html .= igniContactForm();

        return $html;
    }
}
