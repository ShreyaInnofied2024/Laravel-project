@include('inc.header')

<div class="container my-5">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-uppercase" style="color: #a27053;">Users</h1>
        <a href="{{ route('home') }}" class="btn btn-outline-secondary">Go Back</a>
    </div>

    <!-- Product Details Table -->
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Action</th> <!-- Column for delete button -->
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ htmlspecialchars($user->name) }}</td>
                        <td>{{ htmlspecialchars($user->email) }}</td>
                        <td>
                            <!-- Delete button with confirmation -->
                            <a href="" class="btn btn-danger btn-sm"
                               onclick="return confirm('Are you sure you want to delete this user?');">
                               Delete
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
