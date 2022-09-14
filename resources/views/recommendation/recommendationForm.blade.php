@extends('layouts.app')
@section('content')

<div class="container">
        <div class="row mb-5">
            <div class="col-10 offset-1 mt-5">
                <div class="card">
                    <div class="card-header ">
                        <h3 class="text-white">Asset Recommendation</h3>
                    </div>
                    <div class="card-body">
  
                        @if(Session::has('success'))
                            <div class="alert alert-success">
                                {{Session::get('success')}}
                            </div>
                        @endif
                     
                        <form method="POST" action="{{ route('recommendation.store') }}" id="recommendationForm">
                            {{ csrf_field() }}
                              
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group pb-3">
                                        <strong>Name:</strong>
                                        <input type="text" name="name" class="form-control mt-1" placeholder="your name" value="{{ old('name') }}">
                                        @if ($errors->has('name'))
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group pb-3">
                                        <strong>Email:</strong>
                                        <input type="text" name="email" class="form-control mt-1" placeholder=" your email address" value="{{ old('email') }}">
                                        @if ($errors->has('email'))
                                            <span class="text-danger">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group pb-3">
                                        <strong>Asset Name:</strong>
                                        <input type="text" name="asset_name" class="form-control mt-1" placeholder="The Asset you would like to add" value="{{ old('asset_name') }}">
                                        @if ($errors->has('asset_name'))
                                            <span class="text-danger">{{ $errors->first('asset_name') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group pb-3">
                                        <strong>Asset Symbol:</strong>
                                        <input type="text" name="asset_symbol" class="form-control mt-1" placeholder="The Symbol from the Asset you would like to add" value="{{ old('asset_symbol') }}">
                                        @if ($errors->has('asset_symbol'))
                                            <span class="text-danger">{{ $errors->first('asset_symbol') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group text-center py-3">
                                <button class="btn btn-secondary btn-submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
                @guest
                    <a href="{{ route('welcome') }}" class="btn btn-back mb-2">< back</a>
                @else
                    <a href="{{ route('home.index') }}" class="btn btn-back mb-2">< back</a>
                @endguest
            </div>
        </div>
    </div>
@endsection