<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cosmetic Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="index.js"></script>
    <script src="https://kit.fontawesome.com/155c5ab2ca.js" crossorigin="anonymous"></script>
</head>

<body>

<header>
    @include('inc.header')
</header>

<section id="login" class="d-flex justify-content-center align-items-start py-5" style="min-height: 100vh;">
    <div class="login-container bg-white p-4 rounded shadow-sm w-100" style="max-width: 500px;">
        <h2 class="text-center mb-4" style="color: #a27053;">Add Product</h2>
        
        <form id="product" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                    value="{{ old('name') }}" placeholder="Enter product name">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <input type="text" name="quantity" id="quantity" class="form-control @error('quantity') is-invalid @enderror" 
                    value="{{ old('quantity') }}" placeholder="Enter quantity">
                @error('quantity')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <input type="text" name="price" id="price" class="form-control @error('price') is-invalid @enderror" 
                    value="{{ old('price') }}" placeholder="Enter price">
                @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="images" class="form-label">Product Image</label>
                <input type="file" name="images[]" id="images" class="form-control" multiple onchange="previewImages()">
                <div id="image-preview" class="mt-3"></div>
            </div>

            <div class="mb-3">
                <label for="type" class="form-label">Product Type</label>
                <select name="type" id="type" class="form-select @error('type') is-invalid @enderror">
                    <option value="Physical" {{ old('type') == 'Physical' ? 'selected' : '' }}>Physical</option>
                    <option value="Digital" {{ old('type') == 'Digital' ? 'selected' : '' }}>Digital</option>
                </select>
                @error('type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select name="category_id" id="category" class="form-select @error('category_id') is-invalid @enderror">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn" style="background-color: #a27053; color: white;">Submit</button>
        </form>

        <div class="mt-3 text-center">
            <a href="{{ route('products.index') }}" class="text-decoration-none text-secondary">Go Back</a>
        </div>
    </div>
</section>

<script>
    let selectedFiles = [];

    function previewImages() {
        const previewContainer = document.getElementById('image-preview');
        previewContainer.innerHTML = '';

        const files = document.getElementById('images').files;

        selectedFiles = Array.from(files);

        selectedFiles.forEach((file, index) => {
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
                    selectedFiles.splice(index, 1);
                    updateFileInput();
                };

                imageWrapper.appendChild(removeBtn);
                previewContainer.appendChild(imageWrapper);
            };

            reader.readAsDataURL(file);
        });
    }

    function updateFileInput() {
        const fileInput = document.getElementById('images');

        const dataTransfer = new DataTransfer();
        
        selectedFiles.forEach(file => {
            dataTransfer.items.add(file);
        });

        fileInput.files = dataTransfer.files;

        if (fileInput.files.length === 0) {
            fileInput.setAttribute('title', 'No files selected');
        } else {
            fileInput.setAttribute('title', fileInput.files.length + ' files selected');
        }
    }
</script>

</body>
</html>
