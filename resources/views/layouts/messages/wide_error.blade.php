@if(session()->has("error"))
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger">
                {{ session()->get("error") }}
            </div>
        </div>
    </div>
@endif

@if(session()->has("warning"))
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-warning">
                {{ session()->get("warning") }}
            </div>
        </div>
    </div>
@endif

@if(session()->has("success"))
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-success">
                {{ session()->get("success") }}
            </div>
        </div>
    </div>
@endif

@if(session()->has("info"))
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-info">
                {{ session()->get("info") }}
            </div>
        </div>
    </div>
@endif