<?php include 'layout/header.php'; ?>
<?php include 'layout/sidebar.php'; ?>

<div class="container mt-4">

    <h3 class="mb-4">Manage Fields</h3>
    
    <div class="card shadow-sm mb-4">
        <div class="card-body">

            <form id="addFieldForm">
                <input type="hidden" id="form_id">

                <div class="mb-3">
                    <label class="form-label">Field Label</label>
                    <input type="text" name="label" 
                           class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Field Type</label>
                    <select name="type" id="fieldType" 
                            class="form-select" required>
                        <option value="">Select Type</option>
                        <option value="text">Text</option>
                        <option value="textarea">Textarea</option>
                        <option value="radio">Radio</option>
                        <option value="checkbox">Checkbox</option>
                    </select>
                </div>

                <div class="mb-3 d-none" id="optionsDiv">
                    <label class="form-label">
                        Options (comma separated)
                    </label>
                    <input type="text" name="options"
                           class="form-control"
                           placeholder="Good, Average, Poor">
                </div>

                <button type="submit" 
                        class="btn btn-success">
                    Add Field
                </button>
            </form>

        </div>
    </div>

    <h5>Existing Fields</h5>
    <div id="fieldsPreview"></div>

</div>
<script>

const urlParams = new URLSearchParams(window.location.search);
const formId = urlParams.get("form_id");

document.getElementById("form_id").value = formId;

const fieldType = document.getElementById("fieldType");
const optionsDiv = document.getElementById("optionsDiv");

fieldType.addEventListener("change", function() {
    if(this.value === "radio" || this.value === "checkbox"){
        optionsDiv.classList.remove("d-none");
    } else {
        optionsDiv.classList.add("d-none");
    }
});

function loadFields(){

    fetch("../../api/get_fields.php?form_id=" + formId, {
        credentials: "include"
    })
    .then(res => res.json())
    .then(data => {

        const container = 
            document.getElementById("fieldsPreview");

        container.innerHTML = "";

        if(!data.status) return;

        data.fields.forEach(field => {

            container.innerHTML += `
                <div class="card mb-2 shadow-sm">
                    <div class="card-body d-flex justify-content-between align-items-center">

                        <div>
                            <strong>${field.label}</strong>
                            <br>
                            <small class="text-muted">
                                ${field.type}
                                ${field.options ? " | " + field.options : ""}
                            </small>
                        </div>

                        <div>
                            <button class="btn btn-sm btn-warning me-2"
                                onclick="editField(${field.id}, '${field.label}', '${field.type}', '${field.options ?? ''}')">
                                Edit
                            </button>

                            <button class="btn btn-sm btn-danger"
                                onclick="deleteField(${field.id})">
                                Delete
                            </button>
                        </div>

                    </div>
                </div>
            `;
        });

    });
}

loadFields();


// Add Field
document.getElementById("addFieldForm")
.addEventListener("submit", function(e){

    e.preventDefault();

    fetch("../../api/add_field.php", {
        method: "POST",
        credentials: "include",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            form_id: formId,
            label: this.label.value,
            type: this.type.value,
            options: this.options ? this.options.value : null
        })
    })
    .then(res => res.json())
    .then(data => {
        if(data.status){
            this.reset();
            optionsDiv.classList.add("d-none");
            loadFields();
        }
    });

});


// Delete
function deleteField(id){

    if(!confirm("Delete this field?")) return;

    fetch("../../api/delete_field.php", {
        method: "POST",
        credentials: "include",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ field_id: id })
    })
    .then(res => res.json())
    .then(data => {
        if(data.status){
            loadFields();
        }
    });
}


// Edit
function editField(id, label, type, options){

    const newLabel = prompt("Edit Label:", label);
    if(!newLabel) return;

    const newOptions = 
        (type === "radio" || type === "checkbox")
        ? prompt("Edit Options:", options)
        : null;

    fetch("../../api/update_field.php", {
        method: "POST",
        credentials: "include",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            field_id: id,
            label: newLabel,
            type: type,
            options: newOptions
        })
    })
    .then(res => res.json())
    .then(data => {
        if(data.status){
            loadFields();
        }
    });
}

</script>