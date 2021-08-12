// MAIN FUNCTIONS

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

        if (job.status !== 'Chưa nhận') {
            $('button[value="accept"]').prop('disabled', true);
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






