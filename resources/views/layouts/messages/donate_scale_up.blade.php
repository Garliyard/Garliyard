@if(\App\Http\Controllers\Controller::shouldDisplayDonation())

    <div class="panel panel-warning">
        <div class="panel-heading">
            HELP SUPPORT GARLIYARD
        </div>
        <div class="body">
            Thanks for using Garliyard!
            <br><br>
            Over the past few days since being opened to the public, we are amazed to see how the wallet system has taken off.
            <br>
            Some users may have noticed over time that the system has gradually slowed down - we are asking for financial help to sustain and increase capacity.
            <br><br>
            If you would like to donate to the project, you may send GRLC to the following address:
            <br>
            <b>{{ env('DONATION_ADDRESS') }}</b>
        </div>
    </div>
@endif