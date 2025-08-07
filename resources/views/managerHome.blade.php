@extends('layouts.app')

@section('content')
<div class="container">
    <div >
        <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h2>Manager dashboard is under development</h2>
                </div>
            </div>
    </div>
</div>
@endsection
