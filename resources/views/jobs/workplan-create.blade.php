@extends('layouts.app')





@section('content')


    @isset ($successMessage)

        @include('components.flash-message-modal', [
            'modalId' => 'success-modal',
            'alertClass' => 'alert alert-sucess',
            'message' => $successMessage,
        ])

    @endisset

    @if ($errors->any())
        
        @include('components.flash-message-modal', [
            'modalId' => 'error-modal',
            'alertClass' => 'alert alert-danger',
            'message' => $errors->all()[0],
        ])
        
    @endif

    @if (isset($jobAssignId))
            
        @include('components.workplan-modal', ['jobAssignId' => $jobAssignId])

    @else
        
        @include('components.workplan-modal')

    @endif



    <div class="container">
        <form action="{{ route('workplans.delete') }}" method="POST">
            
            @isset($jobAssignId)
                <input type="hidden" name="job_assign_id" value="{{ $jobAssignId }}">
            @endisset

            @isset($jobId)
            
                <input type="hidden" name="job_id" value="{{ $jobId }}">

            @endisset

            @isset($staffId)
            
            <input type="hidden" name="job_id" value="{{ $staffId }}">

            @endisset

            <div class="row ml-0 mb-5">
                @include('components.dynamic-table', [
                    'id' => 'right-table',
                    'cols' => [                              
                        'Từ ngày' => 'from_date',        
                        'Đến ngày' => 'to_date',               
                        'Từ giờ' => 'from_time',   
                        'Đến giờ' => 'to_time',
                        'Nội dung công việc' => 'content',
                        'checkbox' => 'workplan_ids[]'
                    ],
                    'rows' => $workPlans ?? [],                       
                    'min_row' => 4,                          
                ])
            </div>

            <div class="row ml-0">
                @include('components.button-group', [
                    'parentClass' => 'btn-group offset-5',
                    'buttons' => [
                        ['type' => 'button', 'iconClass' => 'fas fa-plus', 'value' => 'Thêm mới', 'action' => 'create'], 
                        ['iconClass' => 'fas fa-trash', 'value' => 'Xóa', 'action' => 'delete'], 
                        
                    ] 
                ])
            </div>

        </form>



        




    </div>
    
    <script src="{{ asset('js/tableCheckbox.js') }}"></script>

    <script>
        
        const setCloseTimeout = (modalSelector, timeout) => {
            $(modalSelector).modal("show").on("shown.bs.modal", function () {
                window.setTimeout(function () {
                    $(modalSelector).modal("hide");
                }, timeout);
            });
        }


        $(document).ready(function() {

            $('button[value="create"]').click(function() {
                $('#workplan-modal').modal('show').on('hidden.bs.modal', function() {
                    $('form input, textarea').val(null);
                });
            });


            $('button[value="reset"]').click(function() {
                $('form input, textarea').not($('input:hidden')).val(null)
            });

            $('button[value="delete"]').prop('disabled', true);


            handleHeadCheckboxClick('thead input:checkbox', 'tbody input:checkbox');

            handleBodyCheckboxClick('thead input:checkbox', 'tbody input:checkbox', function(headSelector, bodySelector, element) {

                if (element.checked) {
 
                    const workPlanId = $(element).closest('tr').attr('id');
					
                    $(element).val(workPlanId);
                    $('button[value="delete"]').prop('disabled', false);
                    
                    if ($(bodySelector).not($('input:checkbox:checked')).length === 0) {
                        $(headSelector).prop('checked', true);
                    }
                }
                else{
                    $(headSelector).prop('checked', false);
                    $(element).removeAttr('value');
                    if ($('tbody input:checkbox:checked').length === 0) {
                        $('button[value="delete"]').prop('disabled', true);
                    }
                }
            });


            setCloseTimeout("#success-modal", 5000);
            setCloseTimeout("#error-modal", 5000);

            


        })

    </script>
@endsection