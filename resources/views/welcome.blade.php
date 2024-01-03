@extends('layout.app')
@section('title', 'Welcome')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <!-- <p style="padding-left: 15px; padding-right: 15px; padding-top: 15px; width: 100%; color: darkorange; text-align: center;">You will be automatically logged out after 60 minutes of inactivity...</p> -->
            <?php
                $modulename = getArrayData(Request::segments(), 0);
                $modulesdata2 = Request::session()->get('modules');
                $modulesdata = collect($modulesdata2)->sortBy('SeqNo')->all();
            ?>
            <div class="row" style="padding: 5px;">
                            <!-- Desktop Design (Hidden on Mobile) -->
                    <div class="d-none d-lg-flex flex-nowrap">
                        @foreach ($modulesdata as $module)
                        <div class="w-50">
                            <div class="card">
                                <div class="card-body">
                                    <a class="gallery-item" href="{{ url($module->Slug.'/dashboard') }}">
                                        <img style="border-radius: 10px;" id="one" src="{{ url('images/'.$module->Slug.'.png') }}" width="100%" height="180px" alt="{{$module->Name}}" title="{{$module->Name}}">
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Mobile Design (Hidden on Desktop) -->
                    <div class="d-lg-none">
                        <div class="row">
                            @foreach ($modulesdata as $module)
                            <div class="col-lg-2 col-md-3 col-sm-6">
                                <div class="card">
                                    <div class="card-body">
                                        <a class="gallery-item" href="{{ url($module->Slug.'/dashboard') }}">
                                            <img src="{{ url('images/'.$module->Slug.'.png') }}" class="img-fluid" alt="{{$module->Name}}" title="{{$module->Name}}">
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

            </div>
            {{-- <div class="row" style="padding: 5px;">
                @foreach ($modulesdata as $module)
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <a class="gallery-item" href="{{ url($module->Slug.'/dashboard') }}"><img id="one" src="{{ url('images/'.$module->Slug.'.png') }}" width="100%" height="180px" alt="{{$module->Name}}" title="{{$module->Name}}"></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div> --}}
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">

        </div>
    </div>
@stop
