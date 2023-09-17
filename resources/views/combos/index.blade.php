@extends('layouts.app')
@section('pageTitle', 'Combo Management')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="card">
                <div class="card-body p-4">
                    <h5 class="card-title">Combo Management</h5>
                    <hr />
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Original Price</th>
                                <th>Sale Price</th>
                                <th>Category</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($combos as $combo)
                                <tr>
                                    <td>{{ $combo->title }}</td>
                                    <td>{!! $combo->short_description !!}</td>
                                    <td>{{ number_format($combo->original_price,0) }}</td>
                                    <td>{{  number_format($combo->sale_price,0) }}</td>
                                    <td>{{ $combo->category->name }}</td>
                                    <td>
                                        <a href="{{ route('combos.show', ['combo' => $combo->id]) }}"
                                            class="btn btn-primary btn-sm">View</a>
                                        <a href="{{ route('combos.edit', ['combo' => $combo->id]) }}"
                                            class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('combos.destroy', ['combo' => $combo->id]) }}"
                                            method="POST" style="display: inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to delete this combo?')">Delete</button>
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
@endsection
