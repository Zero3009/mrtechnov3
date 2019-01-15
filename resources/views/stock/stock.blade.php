@extends('layouts.admin')
@section('main-content')
            <div class="card-header" style="background: #222d32   ; color: #FFFFFF;  opacity: 0.9;">
                <div class="row">
                    <div class="col-md-4" style="float: left;">
                        <h3 class="panel-title" style="margin-top: 10px;">Gestionar stock</h3>
                    </div>
                </div>
            </div>
            <div class="card-body" style="background: #D7D7D7">
                
                
                        @verbatim
                        <stock></stock>
                        @endverbatim
                        
                        <!--<input type="hidden" name="_token" value="{{ csrf_token() }}">-->

                <vuetablestock style="width: 100%"></vuetablestock>    

                <div class="panel-footer">

                </div>
            </div>
@stop
@section('js')
@push('scripts')
<script>
</script>

@endsection