<table class="table table-responsive">
    <thead>
    <tr>
        <th>Transaction ID</th>
        <th>Sent to</th>
        <th>Creation Date</th>
    </tr>
    </thead>

    @foreach($transactions as $transaction)
        <tr>
            <td>{{ $transaction->transaction_id }}</td>
            <td>{{ $transaction->to_address }}</td>
            <td>{{ \Carbon\Carbon::parse($address->created_at)->toDayDateTimeString() }} ({{ \Carbon\Carbon::parse($address->created_at)->diffForHumans() }})</td>
        </tr>
    @endforeach
</table>
