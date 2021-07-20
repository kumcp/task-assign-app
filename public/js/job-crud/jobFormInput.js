


const handleOptionChange = (name, hiddenInputId) => {
    $(`#${name}`).change(function (e) {
        $(`#${hiddenInputId}`).val(e.target.value)
    });
}



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



const initializeJobValues = (jobId) => {
    getJob(jobId).then(job => {
        console.log(job);
        Object.keys(job).forEach(key => {
            let input = document.querySelector(`#${key}`);
            if (input !== null) {
                input.value = job[key];
            }
            
        });

        setValue('#project_name', job.project ? job.project.name : '');

        setSelectedValueDynamic('#assigner_name', job.assigner_id, job.assigner.name);

        setSelectedValueDynamic('#project_code', job.project_id, job.project ? job.project.name : null);
        
        // setSelectedValue('#project_code', job.project_id);
        


        
        setSelectedValueDynamic('#job_type', job.job_type_id, job.type ? job.type.name : null);

        
        // setSelectedValue('#job_type', job.job_type_id);
       
        setSelectedValueDynamic('#parent_job', job.parent_id, job.parent_id ? job.parent.name : null);

        // setSelectedValue('#parent_job', job.parent_id);

        setSelectedValueDynamic('#priority_name', job.priority_id, job.priority ? job.priority.name : null);

        // setSelectedValue('#priority_name', job.priority_id);
    });
}