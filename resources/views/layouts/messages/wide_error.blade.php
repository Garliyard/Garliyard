@if(session()->has("error"))
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger">
                {{ session()->get("error") }}
            </div>
        </div>
    </div>
@endif