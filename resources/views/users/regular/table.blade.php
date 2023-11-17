<table class="table">
    <thead>
        <tr>
            <th>S/N</th>
            <th> Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Registered</th>
            <th>Wallet</th>
            <th># of Fundings</th>
            <th>Total Fundings</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $key => $user)
            @php
                $userEmail = $user->email;
                $walletBalance = $user->wallet ? number_format($user->wallet->balance, 2) : 'N/A';
                
                // $numberOfFundings = DB::table('monnify_transfers')
                //     ->where('customer_email', $userEmail)
                //     ->count();
                
                // $totalFundings = DB::table('monnify_transfers')
                //     ->where('customer_email', $userEmail)
                //     ->sum('amount_paid');
            @endphp
            <tr>
                <td>{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                </td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->phone }}</td>
                <td>{{ $userEmail }}</td>
                <td>
                    @if ($user->created_at)
                        {{ $user->created_at->diffForHumans() }}
                    @else
                        N/A
                    @endif
                </td>                <td>{{ @$walletBalance }}</td>
                <td>{{ @$numberOfFundings }}</td>
                <td>{{ @$totalFundings }}</td>
                <td>
                    <div class="dropdown">
                        <button class="btn btn-secondary btn-sm dropdown-toggle"
                            type="button" id="dropdownMenuButton" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            Actions
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item manual-funding" href="#"
                                data-user-id="{{ $user->id }}"
                                data-user-name="{{ $user->name }}">Manual Funding</a>
                            <a class="dropdown-item change-password" href="#" data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}">Change Password</a>
                            {{-- <a class="dropdown-item" href="">Funding History</a> --}}
                            {{-- <a class="dropdown-item" href="">Spending History</a> --}}
                            <div class="dropdown-divider"></div>
                            <button class="dropdown-item deleteItem" data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}">Delete User</button>
                            <button class="dropdown-item deleteItem">Ban User</button>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
