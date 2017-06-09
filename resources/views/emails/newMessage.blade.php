<div style="background-color: #F2FAFD; padding: 40px;">
    <h3>A new contact message was recieved.</h3>
    <hr>
    <p><strong>From: </strong>{{ $contactMessage->name }}</p>
    <p><strong>Email: </strong><a href="mailto:{{ $contactMessage->email }}">{{ $contactMessage->email }}</a></p>
    <p><strong>Phone: </strong><a href="tel:{{ $contactMessage->phone }}">{{ $contactMessage->phone }}</a></p>
    <p><strong>Message: </strong>{{ $contactMessage->message }}</p>
</div>