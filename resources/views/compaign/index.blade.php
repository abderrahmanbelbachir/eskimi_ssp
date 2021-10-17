@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Compaigns</div>
                </div>
            </div>
            <div class="col-md-12 text-center mt-2">
                <a href="/compaign/create">
                    <button data-v-8486b866="" data-v-7039ca47="" type="button"
                            class="button is-medium is-primary">
                        <span>Create compaign</span>
                    </button>
                </a>
            </div>
            <div class="col-md-12 mt-4">
                <div>
                    <compaign-list></compaign-list>
                </div>
            </div>
        </div>
    </div>
@endsection
