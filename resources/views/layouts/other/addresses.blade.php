<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Address</th>
            <th>Total Amount Received</th>
            <th>Label</th>
            <th>Creation Date</th>
        </tr>
        </thead>

        @foreach($addresses as $address)
            <tr class="{{ (\App\Address::getReceived($address->address) == 0.0) ? "success" : "warning" }}">
                <td>{{ $address->address }}</td>
                <td>{{ number_format(\App\Address::getReceived($address->address), 8) }}</td>
                <td>{{ $address->label or "No Label Present" }}</td>
                <td>{{ \Carbon\Carbon::parse($address->created_at)->toDayDateTimeString() }} ({{ \Carbon\Carbon::parse($address->created_at)->diffForHumans() }})</td>
                <td><a href="/qr-code/{{ $address->address }}" style="color: #000"><span class="fa fa-qrcode"></span></a></td>
            </tr>
        @endforeach
    </table>

</div>