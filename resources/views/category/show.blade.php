@include('inc.header')

@section('content')
<div class="container">
    <h1>Category: {{ $category->name }}</h1>
    <p>Slug: {{ $category->slug }}</p>
    
    <h2>Products in this Category</h2>
    @if($category->products->count() > 0)
        <ul class="list-group">
            @foreach($category->products as $product)
                <li class="list-group-item">
                    <strong>{{ $product->name }}</strong> - ${{ number_format($product->price, 2) }}
                    <span class="badge bg-primary">{{ $product->quantity }} in stock</span>
                </li>
            @endforeach
        </ul>
    @else
        <p class="text-muted">No products found in this category.</p>
    @endif

    <div class="mt-3">
        <a href="{{ route('category.index') }}" class="btn btn-secondary">Back to Categories</a>
    </div>
</div>
@endsection