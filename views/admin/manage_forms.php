<?php include 'layout/header.php'; ?>
<?php include 'layout/sidebar.php'; ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between">
        <h3 class="mb-4">Manage Forms</h3>
        <a href="./create_form.php" class="btn btn-secondary btn-sm mb-4">            <i class="bi bi-cloud-arrow-down-fill"></i>
Create Form</a>
    </div>
    <div id="formsList"></div>

</div>

<script>

function loadForms(){

    fetch("../../api/get_forms_admin.php", {
        credentials: "include"
    })
    .then(res => res.json())
    .then(data => {

        const container = document.getElementById("formsList");
        container.innerHTML = "";

        if(!data.status) return;

        data.forms.forEach(form => {

            container.innerHTML += `
                <div class="card mb-3 shadow-sm">
                    <div class="card-body d-flex justify-content-between align-items-center">

                        <div>
                            <h5>
                            <span class="badge bg-${form.is_active == 1 
                                    ? 'success' 
                                    : 'danger'} "> ${form.title}</span>
                                
                            </h5>
                            <small class="text-muted">${form.description ?? ''}</small>
                        </div>

                        <div>

                            ${form.is_active == 0 
                                ? `<button class="btn btn-sm btn-outline-success me-2 mb-1"
                                    onclick="activateForm(${form.id})">
                                    Set Active
                                </button>`
                                : ''}

                            <a href="manage_fields.php?form_id=${form.id}" 
                            class="btn btn-sm btn-outline-primary me-2 mb-1">
                            <i class="bi bi-kanban-fill"></i>Manage Fields
                            </a>

                            <button class="btn btn-sm btn-outline-info me-2 mb-1"
                                onclick="editForm(${form.id}, '${form.title}', '${form.description ?? ''}')">
                                <i class="bi bi-pencil-square"></i>   Edit
                            </button>

                            <button class="btn btn-sm btn-outline-warning mb-1"
                                onclick="deleteForm(${form.id})">
                                <i class="bi bi-trash"></i>Delete
                            </button>
                        </div>

                    </div>
                </div>
            `;
        });

    });
}

loadForms();

</script>
<script>

function deleteForm(id){

    if(!confirm("Delete this form?")) return;

    fetch("../../api/delete_form.php", {
        method: "POST",
        credentials: "include",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            form_id: id
        })
    })
    .then(res => res.json())
    .then(data => {
        if(data.status){
            showToast("Deleted successfully", "success");
            loadForms();
        }
    });
}

function editForm(id, title, description){

    const newTitle = prompt("Edit Title:", title);
    if(!newTitle) return;

    const newDesc = prompt("Edit Description:", description);

    fetch("../../api/update_form.php", {
        method: "POST",
        credentials: "include",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            form_id: id,
            title: newTitle,
            description: newDesc
        })
    })
    .then(res => res.json())
    .then(data => {
        if(data.status){
            showToast("Updated successfully", "success");
            loadForms();
        }
    });
}

function activateForm(id){

if(!confirm("Make this form active?")) return;

fetch("../../api/set_active_form.php", {
    method: "POST",
    credentials: "include",
    headers: {
        "Content-Type": "application/json"
    },
    body: JSON.stringify({
        form_id: id
    })
})
.then(res => res.json())
.then(data => {
    if(data.status){
        showToast("Activated successfully", "success");
        loadForms();
    }
});
}
</script>
<?php include 'layout/footer.php'; ?>