@include('inc.header')
<div class="container mt-5">
    <h1>Manage Orders</h1>

    <!-- Flash message -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Orders Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>User</th>
                <th>Address</th>
                <th>Total Amount</th>
                <th>Shipping Method</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->user->name }}</td>
                    <td>{{ $order->address }}</td>
                    <td>Rs {{ number_format($order->total_amount, 2) }}</td>
                    <td>{{ $order->shipping_method }}</td>
                    <td>{{ $order->status }}</td>
                    <td>
                        <!-- Update Status Form -->
                        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')

                            <select name="status" class="form-select form-select-sm d-inline w-auto">
                                <option value="Processing" {{ $order->status == 'Processing' ? 'selected' : '' }}>Processing</option>
                                <option value="Out for Delivery" {{ $order->status == 'Out for Delivery' ? 'selected' : '' }}>Out for Delivery</option>
                                <option value="Completed" {{ $order->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                            </select>

                            <button type="submit" class="btn btn-primary btn-sm">Update</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $orders->links() }}
    </div>
</div>
