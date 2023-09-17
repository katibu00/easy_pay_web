@extends('layouts.app')

@section('pageTitle', 'View Combo')

@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <div class="card">
            <div class="card-body p-4">
                <h5 class="card-title">Combo Details</h5>
                <hr />

                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <h6>Title:</h6>
                        <p>{{ $combo->title }}</p>

                        <h6>Short Description:</h6>
                        <p>{!! $combo->short_description !!}</p>

                        <h6>Long Description:</h6>
                        {!! $combo->long_description !!}
                        
                        <h6>Combo Terms:</h6>
                        {!! $combo->combo_terms !!}
                    </div>
                    <div class="col-md-6">
                        <h6>Original Price:</h6>
                        <p>₦{{ number_format($combo->original_price, 2) }}</p>

                        <h6>Sale Price:</h6>
                        <p>₦{{ number_format($combo->sale_price, 2) }}</p>

                        <h6>Prices for Durations:</h6>
                        <p>30 Days: {{ $combo->price_30 ? '₦' . number_format($combo->price_30, 2) : 'N/A' }}</p>
                        <p>60 Days: {{ $combo->price_60 ? '₦' . number_format($combo->price_60, 2) : 'N/A' }}</p>
                        <p>90 Days: {{ $combo->price_90 ? '₦' . number_format($combo->price_90, 2) : 'N/A' }}</p>
                        <p>125 Days: {{ $combo->price_125 ? '₦' . number_format($combo->price_125, 2) : 'N/A' }}</p>

                        <h6>Category:</h6>
                        <p>{{ $combo->category->name }}</p>

                        <h6>Featured Image:</h6>
                        <img src="{{ asset('uploads/'.$combo->featured_image) }}" alt="Featured Image" class="img-thumbnail" width="150">

                        <!-- You can add more details here as needed -->

                        <div class="mt-4">
                            <a href="{{ route('combos.edit', ['combo' => $combo->id]) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('combos.destroy', ['combo' => $combo->id]) }}" method="POST"
                                style="display: inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this combo?')">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
