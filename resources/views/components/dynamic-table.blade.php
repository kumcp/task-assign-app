<table class=" table table-hover table-light table-stripped dynamic-table">
    <thead>
        <tr>
            @foreach ($cols ?? [] as $key => $value)
                @if ($key === 'checkbox')
                    <th><input type="checkbox"></th>
                @else
                    <th scope="col">{{ $key }}</th>
                @endif
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($rows ?? [] as $item)
            <tr>
                @foreach ($cols ?? [] as $key => $value)
                    @if ($value === 'pattern.modified')

                    @else
                        <td>{{ isset($$value) && array_key_exists($item->$value, $$value) ? $$value[$item->$value] : $item->$value }}
                        </td>
                    @endif

                @endforeach
            </tr>
        @endforeach

        {{-- Inject blank row --}}
        @for ($i = 0; $i < $min_row - count($rows); $i++)
            <tr>
                @foreach ($cols ?? [] as $key => $value)
                    <td>
                    </td>
                @endforeach
            </tr>
        @endfor
    </tbody>
</table>


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
