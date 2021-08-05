<div id="tree"></div>
<script src="{{ asset('js/common.js') }}"></script>
<script src="{{ asset('js/treeAPI.js') }}"></script>
<script src="{{ asset('js/assigneeCheckbox.js') }}"></script>

<script type="text/javascript">


    


    $(document).ready(function() {


        


        const tree = $('#tree').tree({
            uiLibrary: 'bootstrap4',
            dataSource: '/api/department',
            checkboxes: true,
            autoload: true,

        });
        


        tree.on('checkboxChange', function(e, $node, record, state) {

            if (record.id) {
               

                const assigneeName = record.text;
                const assigneeId = record.id;

                const processMethodId = $('#process_method').val();
                const processMethodName = $('#process_method option:selected').text();
                
                const duplicate = $(`#assignee-table tr[data-process-method-id="${processMethodId}"]#${assigneeId}`);

                if (state === 'checked' && duplicate.length === 0) {

                    const assigneeInfo = {
                        assigneeId: assigneeId,
                        assigneeName: assigneeName,
                        processMethodId: processMethodId,
                        processMethodName: processMethodName,
                        sms: false,
                        directReport: false,
                        deadline: null

                    };
                    addRowToAssigneeTable('assignee-table', assigneeInfo);

                    addHiddenInput(assigneeInfo);

                    

                }
                else if (state === 'unchecked' && duplicate.length > 0) {
                    
                    removeFromAssigneeTable('assignee-table', assigneeId, processMethodId);
                    removeHiddenInput(`input[data-process-method-id="${processMethodId}"]#${assigneeId}`);


                    
                }
                   
                



            }


        });

        const inputType = ['sms', 'direct_report', 'deadline'];

        inputType.forEach(type => {

            $('#assignee-table').on('change', `input.${type}`, function() {

                const parent = $(this).closest('tr');
                const assigneeId = parent.attr('id');
                const processMethodId = parent.data('processMethodId');

            

                const newValue = type === 'deadline' ? $(this).val() : this.checked;
                
                updateHiddenInput(`input[data-process-method-id="${processMethodId}"][id="${assigneeId}"]`, type, newValue);


            });
        });

        
        

    });
</script>
