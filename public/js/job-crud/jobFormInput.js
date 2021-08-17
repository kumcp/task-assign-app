// MAIN FUNCTIONS
const initializeChildJob = () => {
	
    const parentId = $('#parent_id').val();
    if (parentId) {
        setSelectedValue('#parent_job',  parentId);

        getJob(parentId).then(parentJob => {

            setSelectedValue('#project_code', parentJob.project_id);
            setSelectedValue('#job_type', parentJob.job_type_id);
            setSelectedValue('#priority_name', parentJob.priority_id);

            $('#deadline').val(parentJob.deadline);
            $('#period').val(parentJob.period);

            if (parentJob.files.length > 0) {
                $('#file-count span').html(parentJob.files.length);
                $('#file-count').show();

            }

            initializeFileTable('files', parentJob.files);
        });
        
    }
    
}

const initializeFileTable = (tableId, files) => {
    resetTable(tableId);

    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        const newLink = $('<a/>', {
            href: `http://127.0.0.1:8000/storage/${file.dir}/${file.name}`,
            text: file.name,
            target: '_blank'
        });
        addRowToTable(tableId, i, newLink);
    }
}

const initializeDefaultValues = () => {
    const today = new Date().toLocaleDateString('id');
    $('#created_date').val(today);
    
    if ($('#job_id').val() !== '') {
        const jobId = $('#job_id').val();
        
        let url = $('#workplan').attr('href').split('/').slice(0, -1).join('/');
        $('#workplan').prop('href', `${url}/${jobId}`);
        
        initializeJobValues(jobId);
        
    }
    $("#period_unit").prop("selectedIndex", -1);

}

const initializeJobValues = (jobId) => {

    getJob(jobId).then(job => {

        Object.keys(job).forEach(key => {
            let input = document.querySelector(`#${key}`);
            if (input !== null) {
                input.value = job[key];
            }
            
        });


        setValue('#project_name', job.project ? job.project.name : '');

        setSelectedValueDynamic('#assigner_name', job.assigner_id, job.assigner.name);

        setSelectedValueDynamic('#project_code', job.project_id, job.project ? job.project.name : null);
    
        
        setSelectedValueDynamic('#job_type', job.job_type_id, job.type ? job.type.name : null);

        
       
        setSelectedValueDynamic('#parent_job', job.parent_id, job.parent_id ? job.parent.name : null);


        setSelectedValueDynamic('#priority_name', job.priority_id, job.priority ? job.priority.name : null);

        const curAssigneeId = $('#staff_id').val();
        const curAssigneeList = job.assignees.filter(assignee => {
            return assignee.id === curAssigneeId;
        });
        if (curAssigneeId !== job.assigner_id && curAssigneeList.length > 0) {
            const curAssignee = curAssigneeList[0];
            if (curAssignee.pivot.status !== 'pending') {
                $('button[value="accept"]').prop('disabled', true);
            } 
        }


        if (job.files.length > 0) {
            $('#file-count span').html(job.files.length);
            $('#file-count').show();
        }
        else {
            $('#file-count').hide();
        }

        initializeFileTable('files', job.files);

        initializeAssigneeList(job.assignees, readOnly);




    });
}

const handleSelectInputsChange = () => {
    selectInputs = [
        {name: 'assigner_name', hiddenInputId: 'assigner_id'},
        {name: 'project_code', hiddenInputId: 'project_id'},
        {name: 'job_type', hiddenInputId: 'job_type_id'},
        {name: 'parent_job', hiddenInputId: 'parent_id'},
        {name: 'priority_name', hiddenInputId: 'priority_id'},
        {name: 'chu-tri', hiddenInputId: 'chu-tri-id'},
        {name: 'nhan-xet', hiddenInputId: 'nhan-xet-id'},
    ];

    selectInputs.forEach(element => {
        handleOptionChange(element.name, element.hiddenInputId);
    });

    $('#project_code').change(function () {
        const projectName = $(this).find(':selected').attr('data-hidden');
        $('#project_name').val(projectName);
    });
}

const handleOptionChange = (name, hiddenInputId) => {
    $(`#${name}`).change(function (e) {
        $(`#${hiddenInputId}`).val(e.target.value)
    });
}


// HELPER FUNCTIONS
const setSelectedValue = (selector, value) => {
    $(selector).selectpicker('val', value);
    $(selector).selectpicker('refresh');

}

const setSelectedValueDynamic = (selector, selectedValue, inputValue) => {

    if ($(`select${selector}`).length) {
        setSelectedValue(selector, selectedValue);
    }
    else {

        $(selector).val(inputValue);
    }
}


