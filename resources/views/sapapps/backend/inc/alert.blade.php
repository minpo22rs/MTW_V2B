@if ($errors->any())
    <div class="alert alert-danger background-danger">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <i class="icofont icofont-close-line-circled text-white"></i>
        </button>
        <h4>Error</h4> 
        @foreach ($errors->all() as $k => $error)
            {{ ($k+1) }}.) {{ $error }}<br/>
        @endforeach
    </div>
@endif
@if(session()->has('success'))
    <div class="alert alert-success background-success">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <i class="icofont icofont-close-line-circled text-white"></i>
        </button>
        <h4>Success</h4> {{ session()->get('message') }}
    </div>
@endif
@if(session()->has('fail'))
    <div class="alert alert-danger background-danger">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <i class="icofont icofont-close-line-circled text-white"></i>
        </button>
        <h4>Error</h4> {{ session()->get('message') }}
    </div>
@endif