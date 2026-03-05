<?php include 'layout/header.php'; ?>
<?php include 'layout/sidebar.php'; ?>

<h4 class="mb-4">Submission details </h4>
<div class="d-flex justify-content-between mb-3">

    <input 
    type="text" 
    id="searchRoll" 
    class="form-control w-25" 
    placeholder="Search Roll Number">

    <button class="btn btn-success" onclick="exportCSV()">
    Export CSV
    </button>

</div>
<h4 class="mb-3">Response Summary</h4>

<div id="summarySection" class="mb-5"></div>

<hr>

<h4 class="mb-3">All Responses</h4>
<div id="responses"></div>

<script>
let allData = [];

const urlParams = new URLSearchParams(window.location.search);
const formId = urlParams.get("id");

fetch("../../api/get_submission_details.php?id="+formId,{credentials:"include"})
.then(res=>res.json())
.then(data=>{

allData = data.data;
renderData(allData);

});

function renderData(data){

let container = document.getElementById("responses");
container.innerHTML = "";

let grouped = {};

data.forEach(row => {

if(!grouped[row.roll_number]){
grouped[row.roll_number] = [];
}

grouped[row.roll_number].push(row);

});

let index = 1;

for(const roll in grouped){

container.innerHTML += `
<div class="card mb-4">
<div class="card-header bg-light">
<strong>${index}. Roll Number : ${roll}</strong>
</div>
<div class="card-body">
<table class="table table-bordered">
<thead>
<tr>
<th>Question</th>
<th>Answer</th>
</tr>
</thead>
<tbody id="body_${roll}"></tbody>
</table>
</div>
</div>
`;

grouped[roll].forEach(ans => {

document.getElementById("body_"+roll).innerHTML += `
<tr>
<td>${ans.label}</td>
<td>${ans.answer}</td>
</tr>
`;

});

index++;

}

}

document.getElementById("searchRoll").addEventListener("keyup",function(){

let keyword = this.value.toLowerCase();

let filtered = allData.filter(item =>
item.roll_number.toLowerCase().includes(keyword)
);

renderData(filtered);

});
function exportCSV(){

let csv = "Roll Number,Question,Answer\n";

allData.forEach(row=>{

csv += `${row.roll_number},"${row.label}","${row.answer}"\n`;

});

let blob = new Blob([csv], { type: 'text/csv' });

let url = window.URL.createObjectURL(blob);

let a = document.createElement("a");

a.href = url;
a.download = "form_responses.csv";

a.click();

}

fetch("../../api/get_form_summary.php?id="+formId,{credentials:"include"})
.then(res=>res.json())
.then(data=>{

let container = document.getElementById("summarySection");

let grouped = {};

data.data.forEach(row => {

if(!grouped[row.label]){
grouped[row.label] = [];
}

grouped[row.label].push(row);

});

for(const question in grouped){

container.innerHTML += `
<div class="card mb-4">
<div class="card-header bg-light">
<strong>${question}</strong>
</div>
<div class="card-body">
<table class="table table-bordered">
<thead>
<tr>
<th>Answer</th>
<th>Total Responses</th>
</tr>
</thead>
<tbody id="sum_${question.replace(/\s/g,'')}"></tbody>
</table>
</div>
</div>
`;

grouped[question].forEach(row => {

document.getElementById("sum_"+question.replace(/\s/g,'')).innerHTML += `
<tr>
<td>${row.answer}</td>
<td>${row.total}</td>
</tr>
`;

});

}

});
</script>

<?php include 'layout/footer.php'; ?>