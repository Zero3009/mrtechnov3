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
                <!-- Mensajes de exito-->
                @if (session('status'))
                    <div class="alert alert-success" id="ocultar">
                        {{ session('status') }}
                    </div>
                @endif
                @if(count($errors)>0)
                    <div class="alert alert-warning" role="alert" id="ocultar2">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                    </div>
                @endif 
                <div class="border border-primary">
                    <form method="POST" action="/admin/stock/nuevo/post" accept-charset="UTF-8" class="form-horizontal">
                        @verbatim
                        <stock></stock>
                        @endverbatim
                        <input class="btn btn btn-success" tabindex="1" type="submit" value="Cargar" style="margin-bottom: 10px; margin-left: 10px">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </form>
                </div>
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