<table class="table">
    <thead>
        <tr>
            <th>S/N</th>
            <th> Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Registered</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $key => $user)
            @php
                $userEmail = $user->email;
          
            @endphp
            <tr>
                <td>{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                </td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->phone }}</td>
                <td>{{ $userEmail }}</td>
                <td>{{ $user->created_at->diffForHumans() }}</td>
                <td>
                    <div class="dropdown">
                        <button class="btn btn-secondary btn-sm dropdown-toggle"
                            type="button" id="dropdownMenuButton" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            Actions
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            {{-- <div class="dropdown-divider"></div> --}}
                            <button class="dropdown-item deleteItem" data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}">Delete User</button>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
