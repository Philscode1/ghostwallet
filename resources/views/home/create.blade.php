@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- ADD ASSET -->
            <section class="card">
                <div class="card-header">{{ __('Add Asset') }}</div>
                <div class="card-body">
                    <div id="form" class="form">
                        <form action="{{ route('home.store') }}" method="POST" novalidate>
                            @csrf
                            <label for="asset_id">Asset</label>
                            <select class=" js-example-basic-single form-select form-select-lg" id="asset_id" name="asset_id" style="width: 100%;">
                                @foreach($assets as $asset)
                                <option value="{{$asset->id}}"><span class="addAsset">{{$asset->symbol}}</span> {{$asset->name}}
                                </option>
                                @endforeach
                            </select>
                            @error('asset_id')
                            <div style="color:red;">{{ $message }}</div>
                            @enderror
                            <div class="form-group my-4">
                                <label for="amount">Amount</label>
                                <input type="number" class="form-control" id="amount" name="amount" value=''></input>
                                <p class="text-end">*metal units in oz</p>
                                @error('amount')
                                <div style="color:red;">{{ $message }}</div>
                                @enderror
                            </div>
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                            
                            <button type="submit" class="btn btn-secondary ">Add</button>
                        </form>
                    </div>
                </div>
            </section>
            <section class="card mt-4">
                <div class="card-body container" >
                    <div class="row text-center">
                        <!-- CALCULATOR -->
                        <div id="calculator" class=" col-lg-6 p-3 align-self-center">
                            <p>
                                <label class="pb-2">Grams to ounce Converter:</label>
                                <input id="inputGrams" class="form-control" type="number" placeholder="Grams" oninput="weightConverter(this.value)" onchange="weightConverter(this.value)">
                            </p>
                            <span id="outputOunces"></span>

                        </div>
                        <!-- RECOMMENDATION -->
                        <div id="recommendation" class=" col-lg-6 p-3 pt-5">
                            <div>You didn't found the asset you are looking for... <br>Let us know what we should add next:</div>
                            <a href="{{ route('recommendation.index') }}" class="btn btn-secondary my-3">New Asset</a>
                        </div>
                        
                    </div>
                </div>
            </section>
            <a href="{{ route('home.index') }}" class="btn btn-back">< back</a>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    $('.js-example-basic-single').select2();
    $(".js-example-basic-single").hide();
});

function weightConverter(valNum) {
    document.getElementById("outputOunces").innerHTML=valNum*0.035274+' oz';
}
</script>
@endsection