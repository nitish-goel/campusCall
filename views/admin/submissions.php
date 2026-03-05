<?php include 'layout/header.php'; ?>
<?php include 'layout/sidebar.php'; ?>

<h4 class="mb-4">Form Submissions</h4>

<table class="table table-bordered">
<thead>
<tr>
<th>S.No</th>
<th>Form Title</th>
<th>Total Submissions</th>
<th>Action</th>
</tr>
</thead>

<tbody id="submissionTable"></tbody>
</table>

<script>

function loadForms(){

fetch("../../api/get_submissions.php",{credentials:"include"})
.then(res=>res.json())
.then(data=>{

let table = document.getElementById("submissionTable");
table.innerHTML = "";

data.forms.forEach((form,index)=>{

table.innerHTML += `
<tr>
<td>${index+1}</td>
<td>${form.title}</td>
<td>${form.total_submissions}</td>
<td>
<a href="view_submission.php?id=${form.id}" 
class="btn btn-sm btn-primary">
View
</a>
</td>
</tr>
`;

});

});

}

loadForms();

</script>

<?php include 'layout/footer.php'; ?>