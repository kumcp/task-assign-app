const addRowToTable = (tableId, idx,  data) => {
    let row = $('<tr/>', {
        'class': 'data-row',
    });    
    let content = $('<td/>', {id: idx}).append(data);
    row.append(content);

    $(`#${tableId} tbody`).append(row);
}




const resetTable = tableId => {
    $(`#${tableId} tbody tr`).remove();
}

const addDataToRow = (row, history) => {
    $('#update-histories-table th[scope="col"]').each(function () {
        const key = $(this).attr('data-value');
        if (key === 'created_at') {
            const createdAt = new Date(history[key]);
            row.append($(`<td> ${createdAt} </td>`));
        }
        else {
            row.append($(`<td> ${history[key]} </td>`));
        }
    });
}

const generateUpdateHistoriesTable = () => {
    const jobId = $('#job_id').val();

    getUpdateHistories(jobId).then(histories => {
        histories.forEach(his => {

            let row = $('<tr/>', {
                id: his.id,
                'class': 'data-row',
            });    
        
            addDataToRow(row, his);

            $('#update-job-histories tbody').append(row);
        });
    })
}

const resetUpdateHistoriesTable = () => {
    $('#update-histories-table').find('tr.data-row').each(function () {
            $(this).remove();
    });
}

const handleRowClick = (id, readOnly=false) => {

    $('.alert').each(function () {
        $(this).alert('close');
    });

    $('#job_id').val(id).change();
    $('#history-workplan').show();
    initializeJobValues(id, readOnly);
    
    let url = $('#workplan').attr('href').split('/').slice(0, -1).join('/');
    $('#workplan').prop('href', `${url}/${id}`);

    $('button[value="assignee-detail"]').show();

}