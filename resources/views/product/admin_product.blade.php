@include('inc.header')

<div class="container my-5">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-uppercase" style="color: #a27053;">Products</h1>
        <div>
            @if(auth()->user()->user_role === 'seller')
            <a href="{{ route('seller.products.create') }}" class="btn btn-primary">Add Product</a>
            @elseif(auth()->user()->user_role === 'admin')
            <a href="{{ route('products.create') }}" class="btn btn-primary">Add Product</a>
            @endif
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-dark text-center">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Type</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)

                <tr>
                    <td>{{$product->id}}</td>
                    <td><a style="text-decoration :none; color:black ;" href="{{ route('products.show', $product) }}">{{ $product->name }}</a></td>
                    <td>{{ $product->quantity }}</td>
                    <td>${{ $product->price }}</td>
                    <td>{{ $product->type }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td>
                        @if(auth()->user()->user_role === 'admin')
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">Withdraw</button>
                        </form>
                        @elseif(auth()->user()->user_role === 'seller')
                        <a href="{{ route('seller.products.edit', $product->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('seller.products.destroy', $product) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">Withdraw</button>
                        </form>
                        @endif
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-between mt-4">
        <div>
            @if (Auth::user()->user_role == 'admin')
            <a href="{{ route('products.indexDigital') }}" class="btn btn-outline-secondary">Digital</a>
            <a href="{{ route('products.indexPhysical') }}" class="btn btn-outline-secondary">Physical</a>
            @elseif (Auth::user()->user_role == 'seller')
            <a href="{{ route('seller.products.indexDigital') }}" class="btn btn-outline-secondary">Digital</a>
            <a href="{{ route('seller.products.indexPhysical') }}" class="btn btn-outline-secondary">Physical</a>
            @endif
        </div>
    </div>
</div>