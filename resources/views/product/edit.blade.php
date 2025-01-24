<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cosmetic Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <script src="index.js"></script>
    <script src="https://kit.fontawesome.com/155c5ab2ca.js" crossorigin="anonymous"></script>
</head>
<header>
    @include('inc.header')
</header>

<body>
    <section id="login" class="d-flex justify-content-center align-items-start py-5" style="min-height: 100vh;">
        <div class="login-container bg-white p-4 rounded shadow-sm w-100" style="max-width: 500px;">
            <h2 class="text-center mb-4" style="color: #a27053;">Edit Product</h2>

            <form action="{{ route('products.update', $product->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $product->name) }}" placeholder="Enter product name">
                    @error('name')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" name="quantity" id="quantity"
                        class="form-control @error('quantity') is-invalid @enderror"
                        value="{{ old('quantity', $product->quantity) }}" placeholder="Enter quantity">
                    @error('quantity')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="text" name="price" id="price"
                        class="form-control @error('price') is-invalid @enderror"
                        value="{{ old('price', $product->price) }}" placeholder="Enter price">
                    @error('price')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="type">Product Type</label>
                    <select name="type" id="type" class="form-select @error('type') is-invalid @enderror">
                        <option value="Physical" {{ $product->type == 'Physical' ? 'selected' : '' }}>Physical</option>
                        <option value="Digital" {{ $product->type == 'Digital' ? 'selected' : '' }}>Digital</option>
                    </select>
                    @error('type')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                

                <div class="form-group">
                    <label for="category">Category</label>
                    <select name="category_id" id="category" class="form-select @error('category_id') is-invalid @enderror">
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('category_id')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="images" class="form-label">Add New Images</label>
                    <input type="file" name="images[]" id="images" class="form-control" multiple onchange="previewImages()">
                    <div id="image-preview" class="mt-3"></div>
                </div>




                <button type="submit" class="btn btn-primary">Submit</button>
            </form>

                <div class="form-group">
                    <label>Existing Images</label>
                    <div class="existing-images">
                        @foreach ($product->images as $image)
                        <div id="image-container-{{ $image->id }}">
                            <img src="{{ asset('storage/' . $image->image_path) }}" alt="Product Image" style="width: 100px; height: auto;">
                            
                            <form id="delete-image-{{ $image->id }}" action="{{ route('products.deleteImage', $image->id) }}" method="post" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <a href="#" class="btn btn-danger btn-sm mt-2"
                                    onclick="if(confirm('Are you sure you want to delete this image?')) { event.preventDefault(); document.getElementById('delete-image-{{ $image->id }}').submit(); }">Delete</a>
                            </form>

                        </div>
                        @endforeach

                    </div>
                </div>

                
            <a href="{{ route('product_admin') }}" class="btn btn-secondary mt-3">Go Back</a>
        </div>
    </section>


<script>
    function previewImages() {
    const previewContainer = document.getElementById('image-preview');
    previewContainer.innerHTML = ''; // Clear the preview container

    const files = document.getElementById('images').files;

    // Loop through each selected file and preview it
    Array.from(files).forEach((file, index) => {
        const reader = new FileReader();

        reader.onload = function(e) {
            const imageWrapper = document.createElement('div');
            imageWrapper.classList.add('text-center', 'mb-3');

            const img = document.createElement('img');
            img.src = e.target.result;
            img.classList.add('img-thumbnail');
            img.style.width = '150px';
            imageWrapper.appendChild(img);

            const removeBtn = document.createElement('button');
            removeBtn.textContent = 'Remove';
            removeBtn.classList.add('btn', 'btn-danger', 'btn-sm', 'mt-2');

            removeBtn.onclick = function() {
                previewContainer.removeChild(imageWrapper);

                // Remove the file from the file input
                const fileList = Array.from(document.getElementById('images').files);
                fileList.splice(index, 1);
                const dataTransfer = new DataTransfer();
                fileList.forEach(file => dataTransfer.items.add(file));

                document.getElementById('images').files = dataTransfer.files;
            };

            imageWrapper.appendChild(removeBtn);
            previewContainer.appendChild(imageWrapper);
        };

        reader.readAsDataURL(file);
    });
}
</script>
</body>

</html>