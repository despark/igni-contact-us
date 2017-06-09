<?php

if (! function_exists('igniContactForm')) {
    function igniContactForm()
    {
        $html = '<form action="'.route('form.submit').'" method="POST">
                '.csrf_field().'
                <div>
                    <label for="name">Name</label>
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
                        <textarea class="form-control" id="message" name="message" placeholder="Your message goes here...">'.old('message').'</textarea>
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

        $html = '';

        foreach ($contacts as $contact) {
            $html .= '<div>
                    <label for="type">Type</label>
                    <div>
                        <p>'.$contact->type.'</p>
                    </div>
                </div>
                <div>
                    <label for="message">Content</label>
                    <div>
                        <p>'.$contact->content.'</p>
                    </div>
                </div>';
        }

        return $html;
    }
}

if (! function_exists('igniContactMap')) {
    function igniContactMap()
    {
        $html = '<div id="map" style="width:400px;height:400px;background:yellow"></div>
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
