<table class="table table-responsive">
    <thead>
    <tr>
        <th>Transaction ID</th>
        <th>Amount</th>
        <th>Sent to</th>
        <th>Creation Date</th>
    </tr>
    </thead>

    @foreach($transactions as $transaction)
        <tr>
            <td><a href="/transaction/{{ $transaction->transaction_id }}">{{ $transaction->transaction_id }}</a></td>
            <td>{{ number_format($transaction->amount, 8) }}</td>
            <td>{{ $transaction->to_address }}</td>
            <td>{{ \Carbon\Carbon::parse($address->created_at)->toDayDateTimeString() }} ({{ \Carbon\Carbon::parse($address->created_at)->diffForHumans() }})</td>
        </tr>
    @endforeach
</table>
