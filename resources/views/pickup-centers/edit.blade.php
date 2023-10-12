@extends('layouts.app')
@section('pageTitle', 'Edit Pickup Center')

@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Edit Pickup Center</h5>
            </div>
            <div class="card-body p-4">
                @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif

                <form method="POST" action="{{ route('pickup-centers.update', $pickupCenter->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ $pickupCenter->name }}" required>
                    </div>

                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" name="address" id="address" class="form-control" value="{{ $pickupCenter->address }}" required>
                    </div>

                    <div class="form-group">
                        <label for="city">City</label>
                        <select name="city_id" id="city" class="form-control">
                            @foreach($cities as $city)
                                <option value="{{ $city->id }}" {{ $city->id === $pickupCenter->city_id ? 'selected' : '' }}>{{ $city->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Update Pickup Center</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
