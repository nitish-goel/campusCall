<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campus Feedback Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="/CampusFeedback/assets/css/style.css">
</head>

<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-9">
            
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">

                    <div class="text-center mb-4">
                        <h3 id="formTitle" class="fw-bold"></h3>
                        <p id="formDescription" class="text-muted mb-0"></p>
                    </div>

                    <div class="alert alert-info text-center small">
                        Your responses are anonymous.
                    </div>

                    <form id="studentForm"></form>

                </div>
            </div>

        </div>
    </div>
</div>

<script>
const urlParams = new URLSearchParams(window.location.search);
const formId = urlParams.get("id");

fetch("../../api/get_forms.php?id=" + formId)
.then(res => res.json())
.then(data => {

    if(!data.status){
        alert(data.message);
        return;
    }

    document.getElementById("formTitle").innerText = data.form.title;
    document.getElementById("formDescription").innerText = data.form.description;

    const form = document.getElementById("studentForm");

    data.fields.forEach(field => {

        let inputHTML = "";
        const fieldName = "field_" + field.id;

        if(field.type === "text"){
            inputHTML = `
            <div class="form-group">
                <input type="text" name="${fieldName}" 
                class="form-control" required>
            </div>
            `;
        }

        if(field.type === "textarea"){
            inputHTML = `
            <div class="form-group">
                <textarea name="${fieldName}" 
                class="form-control" required></textarea>
            </div>
            `;
        }

        if(field.type === "radio"){
            const options = field.options.split(",");
            options.forEach(option => {
                inputHTML += `
                    <div class="form-check">
                        <input class="form-check-input" 
                               type="radio" 
                               name="${fieldName}" 
                               value="${option.trim()}" required>
                        <label class="form-check-label">
                            ${option.trim()}
                        </label>
                    </div>
                `;
            });
        }

        if(field.type === "checkbox"){
            const options = field.options.split(",");
            options.forEach(option => {
                inputHTML += `
                    <div class="form-check">
                        <input class="form-check-input" 
                               type="checkbox" 
                               name="${fieldName}[]" 
                               value="${option.trim()}">
                        <label class="form-check-label">
                            ${option.trim()}
                        </label>
                    </div>
                `;
            });
        }

        form.innerHTML += `
            <div class="mb-4">
                <label class="form-label fw-semibold mb-2">
                    ${field.label}
                </label>
                ${inputHTML}
            </div>
        `;
    });
        form.innerHTML += `
            <div class="form-group">
            <label class="form-label">University Roll Number</label>
            <input type="text" 
                name="roll_number" 
                class="form-control" 
                placeholder="Enter your roll number"
                required>
            </div>
            `;
        form.innerHTML += `
        <div class="d-grid mt-3">
            <button type="submit" class="btn btn-primary btn-lg">
                Submit Feedback
            </button>
        </div>
    `;
});

// Submit form
document.addEventListener("submit", function(e){
    e.preventDefault();

    const formData = new FormData(document.getElementById("studentForm"));

    fetch("../../api/submit.php?id=" + formId, {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        if(data.status){
            document.getElementById("studentForm").reset();
        }
    });
});
</script>

</body>
</html>


<!-- 
<body>
    <div class="container">
        <h3 class="txt-center"> Campus Feedback Form</h3>
      <form  method="post" id="">
        <div class="form-group">
            <input type="text" placeholder="Enter username" name="username" class="form-control">
        </div>
        <div class="form-group">
            <input type="password" placeholder="Enter Password" name="password" class="form-control">
        </div>
        <div class="form-btn">
            <input type="submit" value="Login" name="login" class="btn btn-primary">
        </div>
      </form>
     <div><p>Not registered yet <a href="registration.php">Register Here</a></p></div>
    </div>
</body> -->
