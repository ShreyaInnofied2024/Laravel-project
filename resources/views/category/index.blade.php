@include('inc.header')

<div class="container my-5">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-uppercase" style="color: #a27053;">Category</h1>
        <div>

            @if(auth()->user()->user_role === 'admin')
            <a href="{{ route('category.create') }}" class="btn btn-primary">Add Category</a>

            @elseif(auth()->user()->user_role === 'seller')
            <a href="{{ route('seller.category.create') }}" class="btn btn-primary">Add Category</a>
            @endif
        </div>
    </div>

    <!-- Categories Table -->
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-dark text-center">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                <tr>
                    <td>{{ $category->id}} </td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->quantity }}</td>

                    <td>
                        @if(auth()->user()->user_role === 'admin')
                        <a href="{{ route('category.show',$category) }}" class="btn btn-info">Show</a>
                        <form action="{{ route('category.destroy', $category->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>

                        @elseif(auth()->user()->user_role === 'seller')
                        <a href="{{ route('seller.category.show',$category) }}" class="btn btn-info">Show</a>
                        <form action="{{ route('seller.category.destroy', $category->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>