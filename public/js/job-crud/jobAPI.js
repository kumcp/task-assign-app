const getJob = (id, options) => {
    console.log(id);
    return fetch(`/api/jobs/${id}`, {
        method: "GET",
        ...options
    }).then(response => {
        return response.json();
    });
} 

const getUpdateHistories = (id, options) => {
    return fetch(`/api/update-job-histories?job-id=${id}`, {
        method: "GET",
        ...options
    }).then(response => response.json());
} 