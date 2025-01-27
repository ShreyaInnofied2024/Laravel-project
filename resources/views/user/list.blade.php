@include('inc.header')

<div class="container my-5">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-uppercase" style="color: #a27053;">Users</h1>
        <a href="{{ route('home') }}" class="btn btn-outline-secondary">Go Back</a>
    </div>

    <!-- User Details Table -->
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th> <!-- Column for action buttons -->
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ htmlspecialchars($user->name) }}</td>
                    <td>{{ htmlspecialchars($user->email) }}</td>
                    <td>{{ ucfirst($user->user_role) }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <!-- Role Toggle Button -->
                            @if ($user->user_role === 'seller')
                            <form action="{{ route('users.deactivate', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to deactivate this seller?');">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-warning">Deactivate Seller</button>
                            </form>
                            @else
                            <form action="{{ route('users.becomeSeller', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to make this user a seller?');">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success">Be Seller</button>
                            </form>
                            @endif

                            <!-- Delete Button -->
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>