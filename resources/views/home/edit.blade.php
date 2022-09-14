@extends('layouts.app')

@section('pagetitle','edit Asset')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">{{ $asset->name}}</div>
        <div class="card-body">
          <div id="edit-form" class="form">
            <form action="{{ route('home.update',$asset->id) }}" method="POST" novalidate>
              @csrf
              @method('PUT')
              <div class="form-group mb-2">
                <label for="asset_id">Name</label>
                <input type="text" class="form-control" name="asset_id" id="asset_id" value="{{ $asset->name }}" required disabled>
                @error('asset_id')
                <div style="color:red;">{{ $message }}</div>
                @enderror
              </div>
              <div class="form-group mb-4">
                <label for="amount">Amount</label>
                <input type="number" class="form-control" id="amount" name="amount"
                    value='{{ old('amount',$userAsset->amount)}}'></input>
                @error('amount')
                <div style="color:red;">{{ $message }}</div>
                @enderror
              </div>
              <button type="submit" class="btn btn-secondary">edit</button>
            </form>
          </div>
        </div>
      </div>
      <a href="{{ route('home.index') }}" class="btn btn-back">< back</a>
    </div>
  </div>
</div>
@endsection