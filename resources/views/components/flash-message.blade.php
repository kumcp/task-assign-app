@if (session()->get('message') ?? '')
        <div class="alert alert-{{ session()->get('messageType') ?? 'info' }}" role="alert">
            {{ session()->get('message') ?? '' }}
        </div>
        {{ session()->put('message', null) }}
        {{ session()->put('messageType', null) }}
@endif

{{-- A custom flash message with color --}}