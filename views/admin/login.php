
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <div class="container">
        
      <form  method="post" id="loginForm">
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
     <!-- <div><p>Not registered yet <a href="registration.php">Register Here</a></p></div> -->
    </div>
</body>
<script>
document.getElementById("loginForm").addEventListener("submit", async function(e){
    e.preventDefault();

    const formData = new FormData(this);

    const response = await fetch("/CampusFeedback/api/login.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            username: formData.get("username"),
            password: formData.get("password")
        })
    });

    const data = await response.json();

    if(data.status){
        window.location.href = "/CampusFeedback/views/admin/dashboard.php";
        showToast(data.message, "success");

    } else {
        alert(data.message);
    }
});
</script>
</html>