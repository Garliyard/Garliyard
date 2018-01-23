<table class="table table-responsive">
    <thead>
    <tr>
        <th>Address</th>
        <th>Label</th>
        <th>Creation Date</th>
        <th>QR</th>
    </tr>
    </thead>

    @foreach($addresses as $address)
        <tr>
            <td>{{ $address->address }}</td>
            <td>{{ $address->label or "No Label Present" }}</td>
            <td>{{ \Carbon\Carbon::parse($address->created_at)->toDayDateTimeString() }} ({{ \Carbon\Carbon::parse($address->created_at)->diffForHumans() }})</td>
            <td><a href="/qr-code/{{ $address->address }}" style="color: #000"><span class="fa fa-qrcode"></span></a></td>
            <td><a class="pubkey-export" key="{{ $address->address }}" href="#" style="color: #000"><span class="fa fa-download" title="Download private key"></span></a></td>
        </tr>
    @endforeach
</table>
