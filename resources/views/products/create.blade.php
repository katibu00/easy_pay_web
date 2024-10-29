@extends('layouts.app')
@section('pageTitle','Create New Product')
@section('css')
<link href="/admin/plugins/Drag-And-Drop/dist/imageuploadify.min.css" rel="stylesheet" />
@endsection

@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <div class="card">
            <div class="card-body p-4">
                <h5 class="card-title">Add New Product</h5>
                <hr/>
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <!-- Display success message -->
                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif


                <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-body mt-4">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="border border-3 p-4 rounded">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Product Title</label>
                                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="title" value="{{ old('title') }}" placeholder="Enter product title">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Product Description</label>
                                        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="5">{{ old('description') }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="image-uploadify" class="form-label">Product Images</label>
                                        <input name="images[]" id="image-uploadify" type="file" accept=".jpg,.jpeg,.png" multiple>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="border border-3 p-4 rounded">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="original_price" class="form-label">Original Price</label>
                                            <input type="number" name="original_price" step="any" class="form-control @error('original_price') is-invalid @enderror" id="original_price" value="{{ old('original_price') }}" placeholder="00.00">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="sale_price" class="form-label">Sale Price</label>
                                            <input type="number" name="sale_price" step="any" class="form-control @error('sale_price') is-invalid @enderror" id="sale_price" value="{{ old('sale_price') }}" placeholder="00.00">
                                        </div>

                                        <div class="col-12">
                                            <label for="quantity_in_stock" class="form-label">Quantity In Stock</label>
                                            <input type="number" name="quantity_in_stock" step="1" class="form-control @error('quantity_in_stock') is-invalid @enderror" id="quantity_in_stock" value="{{ old('quantity_in_stock') }}" placeholder="Enter Quantity">
                                        </div>

                                        <div class="col-12">
                                            <label for="category_id" class="form-label">Product Category</label>
                                            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" id="category_id" value="{{ old('category_id') }}">
                                                <option value=""></option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                       
              
                                        <div class="col-12">
                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-primary">Save Product</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!--end row-->
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>

<script>
   $(document).ready(function () {
    $('#image-uploadify').imageuploadify({
        maxFiles: 1 
    });
});
    CKEDITOR.replace('description');
</script>
<script src="/admin/plugins/Drag-And-Drop/dist/imageuploadify.min.js"></script>


@endsection
