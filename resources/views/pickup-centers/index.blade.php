@extends('layouts.app')
@section('pageTitle', 'Pickup Centers')

@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Pickup Centers</h5>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPickupCenterModal">
                    Add New Pickup Center
                </button>
            </div>
            <div class="card-body p-4">
                <hr />

                @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>City</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pickupCenters as $pickupCenter)
                        <tr>
                            <td>{{ $pickupCenter->id }}</td>
                            <td>{{ $pickupCenter->name }}</td>
                            <td>{{ $pickupCenter->address }}</td>
                            <td>{{ $pickupCenter->city->name }}</td>
                            <td>
                                <a href="{{ route('pickup-centers.edit', $pickupCenter->id) }}" class="btn btn-primary">Edit</a>
                                <form action="{{ route('pickup-centers.destroy', $pickupCenter->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this Pickup Center?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Pickup Center Modal -->
<div class="modal fade" id="addPickupCenterModal" tabindex="-1" role="dialog" aria-labelledby="addPickupCenterModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('pickup-centers.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addPickupCenterModalLabel">Add New Pickup Center</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea name="address" id="address" class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="city_id">City</label>
                        <select name="city_id" id="city_id" class="form-control" required>
                            @foreach($cities as $city)
                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Pickup Center</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
