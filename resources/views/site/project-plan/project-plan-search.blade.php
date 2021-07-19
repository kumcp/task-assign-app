@extends('layouts.app')

@section('content')
    <div class="container">
        <fieldset class="p-3 mb-3" style="border: 1px solid; border-radius: 15px">
            <legend class="w-auto">Kế hoạch dự án</legend>

            <div class="row mb-4 ml-0">
                <form action="{{route('project-plan.search')}}" class="w-100" method="POST">
                    @csrf
                    <div class="form-group-row mb-3">
                        @include('components.select', [
                            'name' => 'project_id',
                            'label' => 'Dự án',
                            'type' => 'date',
                            'options' => $project,
                        ])
                        @include('components.button-group', [
                             'buttons' => [
                                 ['class' => 'btn btn-primary', 'iconClass' => 'fas fa-search', 'value' => 'Tìm kiếm', 'action' => 'search']
                             ]
                         ])
                    </div>

                </form>
            </div>
        </fieldset>

    </div>
    @include('components.table', [
                    'fields' => [
                        'name_job' => 'name',
                        'object_handling' => 'name_oject',
                        'phone' => 'phone',
                        'email' => 'email',
                        'name_deadline' => 'deadline',
                        'delivery_volume' => '0',
                        'timesheet_volume' => '0',


                       ],
                    'items' => $jobAssigns,
                    'edit_route' => 'skill.edit'
                ])

    {{$jobAssigns->links()}}

@endsection