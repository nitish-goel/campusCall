
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<style>
    .form-group {
        position: relative;
        margin-bottom: 20px;
    }
    .form-control {
        padding-right: 40px; /* Leave space for the icon */
    }
    .form-group i {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #666;
    }
    .field-icon:hover {
        color: #333;
    }
</style>
<body>
    <div class="container">
        
      <form  method="post" id="loginForm">
        <div class="form-group">
            <input type="text" placeholder="Enter username" name="username" class="form-control">
            <i class="fa-solid fa-user"></i>
        </div>
        <div class="form-group">
            <input id="password-field" type="password" class="form-control" name="password" placeholder="Enter Password">
            <i toggle="#password-field" class="fa-regular fa-eye-slash field-icon toggle-password"></i>
        </div>
        <div class="form-btn">
            <input type="submit" value="Login" name="login" class="btn btn-primary">
        </div>
      </form>
     <!-- <div><p>Not registered yet <a href="registration.php">Register Here</a></p></div> -->
    </div>
</body>
<script>
    // 1. Select all elements with the class
    document.querySelectorAll('.toggle-password').forEach(button => {
        
        // 2. Add the click event listener
        button.addEventListener('click', function() {
            
            // 3. Toggle the eye icons
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');

            // 4. Find the target input using the 'toggle' attribute
            const selector = this.getAttribute('toggle');
            const input = document.querySelector(selector);

            if (input) {
                // 5. Switch the type
                if (input.type === "password") {
                    input.type = "text";
                } else {
                    input.type = "password";
                }
            }
        });
    });
</script>
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