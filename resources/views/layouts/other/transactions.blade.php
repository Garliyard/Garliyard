<div class="table-responsive">
    <table class="table">
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
                <td><a href="/transaction/{{ $transaction->transaction_id }}">{{ (isset($dont_truncate)) ? $transaction->transaction_id . "..." : substr($transaction->transaction_id,0,16) }}</a></td>
                <td>{{ number_format($transaction->amount, 8) }}</td>
                <td>{{ $transaction->to_address }}</td>
                <td>{{ \Carbon\Carbon::parse($transaction->created_at)->toDayDateTimeString() }} ({{ \Carbon\Carbon::parse($transaction->created_at)->diffForHumans() }})</td>
            </tr>
        @endforeach
    </table>
</div>
