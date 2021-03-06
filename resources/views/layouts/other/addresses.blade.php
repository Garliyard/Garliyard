<div class="table-responsive">
    <table class="table table-hover">
        <thead>
        <tr>
            <th>Address</th>
            <th>Total Amount Received</th>
            <th>Label</th>
            <th>Creation Date</th>
            <th>QR</th>
        </tr>
        </thead>

        @foreach($addresses as $address)
            <tr class="{{ (\App\Address::getReceived($address->address) != 0.0) ? "warning" : "" }}">
                <td>{{ $address->address }}</td>
                <td>{{ number_format(\App\Address::getReceived($address->address), 8) }}</td>
                <td>
                    {{ ($address->label) ? $address->getLabel() : "No Label Present" }}
                    &nbsp; <a href="/edit-label/{{ $address->address }}"><span class="fa fa-pencil"></span></a>
                </td>
                <td>{{ \Carbon\Carbon::parse($address->created_at)->toDayDateTimeString() }} ({{ \Carbon\Carbon::parse($address->created_at)->diffForHumans() }})</td>
                <td><a href="/qr-code/{{ $address->address }}" style="color: #000"><span class="fa fa-qrcode" title="Get QR Code"></span></a></td>
            </tr>
        @endforeach
    </table>
</div>