@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit Compaign {{$compaign->id}}</div>
                </div>
            </div>
            <div class="col-md-12">
                <div>
                    <update-compaign id="{{$compaign->id}}"
                                     name="{{$compaign->name}}"
                                     from_update="{{$compaign->from}}"
                                     to_update="{{$compaign->to}}"
                                     daily_budget="{{$compaign->daily_budget}}"
                                     files_to_keep="{{$compaign->uploads}}"></update-compaign>
                </div>
            </div>
        </div>
    </div>
@endsection
