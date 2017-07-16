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
                    <label>Name</label>
                    <div>
                        <input type="text" name="name" value="'.old('name').'" required autofocus maxlength="255">
                    </div>
                </div>

                <div>
                    <label>Email</label>
                    <div>
                        <input type="email" name="email" value="'.old('email').'" required maxlength="255">
                    </div>
                </div>

                <div>
                    <label>Phone</label>
                    <div>
                        <input type="text" name="phone" value="'.old('phone').'" required maxlength="50">
                    </div>
                </div>
                <div>
                    <label>Message</label>
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
        $mapInfo = Despark\Cms\ContactUs\Models\Contact::whereType('address')->first();

        if ($mapInfo) {
            $lat = $mapInfo->latitude;
            $lng = $mapInfo->longitude;
            $title = $mapInfo->content;
        } else {
            $lat = -33.866621;
            $lng = 151.195856;
            $title = 'Google';
        }

        $html = '
            <hr>
            <h1 style="text-align: center;">Map</h1>
            <hr>
            <div id="map" style="width:400px;height:400px;margin-left:auto;margin-right:auto;"></div>
            <script>
            function myMap() {
            var mapOptions = {
                center: new google.maps.LatLng('.$lat.', '.$lng.'),
                zoom: 17
            }
            var map = new google.maps.Map(document.getElementById("map"), mapOptions);
            var marker = new google.maps.Marker({
              position: {lat: '.$lat.', lng: '.$lng.'},
              map: map,
              title: "'.$title.'"
            });
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
