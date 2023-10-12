@extends('layouts.app')
@section('pageTitle', 'Edit City')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Edit City</h5>
                </div>
                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('cities.update', $city->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">City Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $city->name }}" required>
                        </div>
                        <div class="form-group">
                            <label for="state_id">Select State</label>
                            <select class="form-select" id="state_id" name="state_id" required>
                                <option value=""></option>
                                @foreach ($states as $state)
                                    <option value="{{ $state->id }}" @if($state->id === $city->state_id) selected @endif>{{ $state->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">Update City</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
