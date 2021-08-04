const addRowToAssigneeTable = (tableId, data, addCheckboxCol=false) => {


    let row = $('<tr/>', {
        id: data.id ? data.id : data.assigneeId,
        'data-process-method-id': data.processMethodId
    });
    if (data.jobId) {
        row.attr('data-job-id', data.jobId);
    }

    row.append($('<td/>', {class: 'name'}).text(data.assigneeName));

    row.append($('<td/>', {class: 'process_method'}).text(data.processMethodName));

    row.append(
        $('<td/>').append($('<input/>', {
            type: 'checkbox',
            class: 'direct_report'
        }).prop('checked', data.directReport)
    ));

    row.append(
        $('<td/>').append($('<input/>', {
            type: 'date',
            class: 'deadline',
            value: data.deadline
        }))
    );
                    
    row.append(
        $('<td/>').append($('<input/>', {
            type: 'checkbox',
            class: 'sms'
        }).prop('checked', data.sms)

    ));      

    if (addCheckboxCol) {
        row.append(
            $('<td/>').append($('<input/>', {
                name: 'job_assign_ids[]',
                type: 'checkbox',
            })
    
        ));     
    }

    $(`#${tableId} tbody`).append(row);


}

const removeFromAssigneeTable = (tableId, rowId, processMethodId) => {

    $(`#${tableId} tbody tr[data-process-method-id="${processMethodId}"]#${rowId}`).remove();
}


const addHiddenInput = data => {
    let newInput = $('<input/>', {
        type: 'hidden',
        'data-process-method-id': data.processMethodId, 
        name: 'job_assigns[]',
        id: data.assigneeId,
        value: JSON.stringify({
            staff_id: data.assigneeId, 
            process_method_id: data.processMethodId,
            sms: data.sms,
            deadline: null,
            direct_report: data.directReport
        })
    });


    $('form').append(newInput);
}

const addOldJobAssignInput = data => {
    let newInput = $('<input/>', {
        type: 'hidden',
        name: 'old_job_assigns[]',
        id: data.id,
        value: JSON.stringify({
            id: data.id,
            staff_id: data.assigneeId, 
            process_method_id: data.processMethodId,
            sms: data.sms,
            deadline: data.deadline,
            direct_report: data.directReport
        })
    });


    $('form').append(newInput);
}

const removeHiddenInput = (inputSelector) => {

    $(inputSelector).remove();
}

const updateHiddenInput = (inputSelector, field, value) => {

    const oldValue = JSON.parse($(inputSelector).val());
    
    $(inputSelector).val(JSON.stringify({
        ...oldValue,
        [field]: value
    }));
}
