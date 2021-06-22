@extends('layout.admin-dashboard')

@section('static')
    @parent
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection


@section('page')
    @if ($message ?? '')
        <div class="alert alert-{{ $messageType ?? 'info' }}" role="alert">
            {{ $message ?? '' }}
        </div>
    @endif

    <h3 class="title">{{ __('title.user-management') }}</h3>

    <div class="table-content container">
        {!! Form::open(['url' => route('update-account')]) !!}
        <table class=" table table-hover table-light table-stripped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Username</th>
                    <th scope="col">Email</th>
                    <th scope="col">Status</th>
                    <th scope="col">Created</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users ?? [] as $user)
                    <tr>
                        <th scope="row">{{ $user->id }}</th>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->email }}</td>
                        <td><select name="user-status[{{ $user->id }}]" class="form-select status-select"
                                aria-label="Select user status">
                                @foreach ($statusOptions as $statusOption)
                                    <option value="{{ $statusOption }}"
                                        {{ $statusOption === $user->status ? 'selected' : '' }}>{{ $statusOption }}
                                    </option>
                                @endforeach
                            </select></td>
                        <td>{{ $user->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination-bar">
            <nav aria-label="User pagination">
                <ul class="pagination">
                    <li class="page-item"><a class="page-link" href="?page=1">{{ __('title.first') }}</a></li>

                    @if ($currentPage - 1 > 0)
                        <li class="page-item"><a class="page-link"
                                href="?page={{ $currentPage - 1 }}">{{ $currentPage - 1 }}</a></li>
                    @endif

                    <li class="page-item"><a class="page-link" href="?page={{ $currentPage }}">{{ $currentPage }}</a>
                    </li>

                    @if ($currentPage + 1 <= $totalPage)
                        <li class="page-item"><a class="page-link"
                                href="?page={{ $currentPage + 1 }}">{{ $currentPage + 1 }}</a></li>
                    @endif
                    <li class="page-item"><a class="page-link"
                            href="?page={{ $totalPage }}">{{ __('title.last') }}</a></li>
                    <li class="page-item"><a class="page-link" href="?">(</a></li>
                    <li class="perpage-input"><input type="text" maxlength="2" class="form-control"
                            value="{{ $limit }}" name="numberPerPage"></li>
                    <li class="page-item"><a class="page-link" onclick="updateNumberPerPage()">/page)</a></li>
                </ul>
            </nav>

            <ul></ul>
        </div>
        {{ Form::Submit('Update', ['class' => 'btn btn-primary']) }}

        {!! Form::close() !!}
    </div>


@endsection
