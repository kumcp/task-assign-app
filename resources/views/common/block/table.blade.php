<table class=" table table-hover table-light table-stripped">
    <thead>
        <tr>
            @foreach ($fields ?? [] as $key => $value)
                <th scope="col">{{ __("title.$key") }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($items ?? [] as $item)
            <tr>
                <td scope="row">{{ $item->id }}</td>
                @foreach ($fields ?? [] as $key => $value)

                    @if ($value === 'pattern.modified')
                        <td><a href="{{ route($edit_route ?? 'edit', ['id' => $item->id]) }}"
                                class="btn btn-primary">{{ __('title.edit') }}</a>
                        </td>
                    @elseif ($value === 'pattern.image')
                        <td>
                            @if($item->image)
                            <img src="{{ $item->image }}" alt="" srcset="" width="50" height="50">
                            @endif
                        </td>
                    @elseif (strpos($value, 'custom.'))
                        @yield($value, $item)
                    @else 
                        <td>{{ isset($$value) && array_key_exists($item->$value, $$value) ? $$value[$item->$value] : $item->$value }}
                        </td>
                    @endif

                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>


{{-- Example of invocation
    @include('common.block.table', [
        'fields' => [                               // Field name and value
            'modify' => 'pattern.modified',         // pattern.modified is a specific value field
            'exam-name' => 'name',                  // will show $item->name
            'status' => 'status',   
            'exam-type' => 'type',
            'created-at' => 'created_at'
        ],
        'items' => $exams,                          // Parse data items
        'edit_route' => 'exam-detail',              // When click on edit button
        'delete_route' => 'delete-exam',            // When click on delete button
        'type' => [                                 // If it's necessary to transform value in exam-type column to a readable info
                                                    // use name of the value field with the corresponding value
            'multiple_choice' => __('title.multi_choice'),
            'mixing' => __('title.mixing')
            ]
        ]) --}}
