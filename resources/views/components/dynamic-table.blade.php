@if (isset($id))
    <table class=" table table-hover table-light table-stripped dynamic-table" id="{{$id}}">
@else
    <table class=" table table-hover table-light table-stripped dynamic-table">
@endif
{{-- <table class=" table table-hover table-light table-stripped dynamic-table" {{ isset($id) ? 'id = {{$id}}' : '' }}> --}}
    <thead>
        <tr>
            @foreach ($cols ?? [] as $key => $value)
                @if ($key === 'checkbox')
                    <th><input type="checkbox" ></th>
                @else
                    <th scope="col" data-value="{{$value}}">{{ $key }}</th>
                @endif
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($rows ?? [] as $item)
            <tr class="data-row" id="{{isset($idField) ? $item[$idField] : $item['id']}}">
                @foreach ($cols ?? [] as $key => $value)
                    @if ($value === 'pattern.modified')
                    @elseif ($key === 'checkbox')
                        <td><input name="{{ $value }}" type="checkbox"></td>
                    @else
                        <td>{{ isset($$value) && array_key_exists($item->$value, $$value) ? $$value[$item->$value] : $item->$value }}
                        </td>
                    @endif

                @endforeach
            </tr>
        @endforeach

        

        {{-- Inject blank row --}}
        @isset($min_row)
            @for ($i = 0; $i < $min_row - count($rows); $i++)
                <tr>
                    @foreach ($cols ?? [] as $key => $value)
                        <td>
                        </td>
                    @endforeach
                </tr>
            @endfor
        @endisset

    </tbody>
</table>
@isset($pagination)
    {{ $rows->onEachSide(2)->links('pagination::bootstrap-4') }}
@endisset




{{-- Example of invocation
    @include('common.block.table', [
        'cols' => [                               // Field name and value
            'modify' => 'pattern.modified',         // pattern.modified is a specific value field
            'exam-name' => 'name',                  // will show $item->name
            'status' => 'status',   
            'exam-type' => 'type',
            'created-at' => 'created_at'
        ],
        'rows' => $exams,                          // Parse data items
        'min_row' => 4,                             // The minimum row number is 4. If array does not have enough rows, then inject blank rows instead
        'type' => [                                 // If it's necessary to transform value in exam-type column to a readable info
                                                    // use name of the value field with the corresponding value
            'multiple_choice' => __('title.multi_choice'),
            'mixing' => __('title.mixing')
            ]
        ]) --}}
