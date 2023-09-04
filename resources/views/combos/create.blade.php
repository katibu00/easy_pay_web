@extends('layouts.app')
@section('pageTitle','Create New Combo')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="card">
                <div class="card-body p-4">
                    <h5 class="card-title">Add New Combo</h5>
                    <hr />
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
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif


                    <form method="POST" action="{{ route('combos.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-body mt-4">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="border border-3 p-4 rounded">
                                        <div class="mb-3">
                                            <label for="title" class="form-label">Combo Title</label>
                                            <input type="text" name="title"
                                                class="form-control @error('title') is-invalid @enderror" id="title" value="{{ old('title') }}" placeholder="Enter Combo title">
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="description">Combo Description</label>
                                            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                                                rows="5">{{ old('description') }}</textarea>
                                        </div>

                                        <div id="product-rows">
                                            <div class="mb-3 row product-row">
                                                <div class="col-md-5">
                                                    <label for="product_id[]" class="form-label">Product</label>
                                                    <select name="product_id[]" class="form-select product-select">
                                                        <option value=""></option>
                                                        @foreach ($products as $product)
                                                            <option value="{{ $product->id }}">{{ $product->title }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="quantity[]" class="form-label">Quantity</label>
                                                    <input type="number" name="quantity[]" class="form-control quantity"
                                                        min="1" value="1">
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="add-remove" class="form-label">Actions</label>
                                                    <div class="d-flex">
                                                        <button type="button" class="btn btn-danger remove-row"><i
                                                                class='bx bx-trash'></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                         
                                        </div>
                                        <button type="button" class="btn btn-success" id="add-new-row"><i
                                            class='bx bx-plus'></i>Add New Row</button>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="border border-3 p-4 rounded">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label for="original_price" class="form-label">Original Price</label>
                                                <input type="number" name="original_price" step="any"
                                                    class="form-control @error('original_price') is-invalid @enderror"
                                                    id="original_price" value="{{ old('original_price') }}"
                                                    placeholder="00.00">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="sale_price" class="form-label">Sale Price</label>
                                                <input type="number" name="sale_price" step="any"
                                                    class="form-control @error('sale_price') is-invalid @enderror"
                                                    id="sale_price" value="{{ old('sale_price') }}" placeholder="00.00">
                                            </div>

                                            <div class="col-12">
                                                <label for="category_id" class="form-label">Combo Category</label>
                                                <select name="category_id"
                                                    class="form-select @error('category_id') is-invalid @enderror"
                                                    id="category_id" value="{{ old('category_id') }}">
                                                    <option value=""></option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label for="location_id" class="form-label">Location</label>
                                                <select name="location_id"
                                                    class="form-select @error('location_id') is-invalid @enderror"
                                                    id="location_id" value="{{ old('location_id') }}">
                                                    <option value=""></option>
                                                    @foreach ($locations as $location)
                                                        <option value="{{ $location->id }}">{{ $location->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>


                                            <div class="col-12">
                                                <label for="featured_image" class="form-label">Featured Image</label>
                                                <img src="/uploads/no-image.jpg" id="image-thumbnail" width="400px" height="450px" class="img-thumbnail mb-2" alt="Featured Image">

                                                <div class="input-group">
                                                    <input type="file" name="featured_image" id="featured_image" accept=".jpg,.jpeg,.png" style="display: none;">
                                                    <input type="text" id="image-placeholder" class="form-control" placeholder="Upload a featured image" readonly>
                                                    <button type="button" class="btn btn-primary" id="upload-featured-image">Upload</button>
                                                </div>
                                                <!-- Display a placeholder image -->
                                            </div>

                                            <div class="col-12">
                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-primary">Save Combo</button>
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
        CKEDITOR.replace('description');
    </script>

<script>
    $(document).ready(function () {
        // Event listener for the "Upload Featured Image" button
        $('#upload-featured-image').click(function () {
            $('#featured_image').click(); // Trigger the file input click
        });

        // Event listener for file input change
        $('#featured_image').change(function () {
            const input = $(this)[0];
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    // Display a thumbnail of the selected image in the placeholder
                    $('#image-thumbnail').attr('src', e.target.result);
                    $('#image-placeholder').val(input.files[0].name);
                };
                reader.readAsDataURL(input.files[0]);
            }
        });
    });
</script>



    <script>
        $(document).ready(function() {
            const productRows = $('#product-rows');
            const addNewRowBtn = $('#add-new-row');

            // Function to clone a product row without labels
            function cloneProductRow() {
                const newRow = productRows.find('.product-row').first().clone();
                newRow.find('label').remove(); // Remove labels from the cloned row
                newRow.find('.product-select').val('');
                newRow.find('.quantity').val('1');
                newRow.find('.remove-row').click(function() {
                    newRow.remove();
                });
                productRows.append(newRow);
            }

            // Event listener for "Add New Row" button
            addNewRowBtn.click(function() {
                cloneProductRow();
            });

            // Event listener for initial "Remove" buttons
            productRows.on('click', '.remove-row', function() {
                $(this).closest('.product-row').remove();
            });
        });
    </script>
@endsection
