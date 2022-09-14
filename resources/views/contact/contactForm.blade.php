@extends('layouts.app')
@section('content')

<div class="container">
        <div class="row mb-5">
            <div class="col-10 offset-1">
                <div class="card">
                    <div class="card-header ">
                        <h3 class="text-white">Contact Us</h3>
                    </div>
                    <div class="card-body">

                        @if(Session::has('success'))
                            <div class="alert alert-success">
                                {{Session::get('success')}}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('contact.us.store') }}" id="contactUSForm">
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
                                        <strong>Phone:</strong>
                                        <input type="text" name="phone" class="form-control mt-1" placeholder="(optional)" value="{{ old('phone') }}">
                                        @if ($errors->has('phone'))
                                            <span class="text-danger">{{ $errors->first('phone') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group pb-3">
                                        <strong>Subject:</strong>
                                        <input type="text" name="subject" class="form-control mt-1" placeholder="subject" value="{{ old('subject') }}">
                                        @if ($errors->has('subject'))
                                            <span class="text-danger">{{ $errors->first('subject') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group pb-3">
                                        <strong>Message:</strong>
                                        <textarea name="message" rows="3" class="form-control mt-1">{{ old('message') }}</textarea>
                                        @if ($errors->has('message'))
                                            <span class="text-danger">{{ $errors->first('message') }}</span>
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