<?php
$host = 'localhost:3306';  
$user = 'root';  
$pass = '';  
$db_name = 'buy_sell'; 

try {
    // Establish connection
    $conn = mysqli_connect($host, $user, $pass, $db_name);  

    // Attempt to insert data into the table
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $book_title = mysqli_real_escape_string($conn, $_POST['book_title']);
        $branch = mysqli_real_escape_string($conn, $_POST['branch']);
        $publication = mysqli_real_escape_string($conn, $_POST['publication']);
        $date = mysqli_real_escape_string($conn, $_POST['date']);
        $type = mysqli_real_escape_string($conn, $_POST['type']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);
    

        // File upload
       $file_name = $_FILES['image']['name'];
       $tempname = $_FILES['image']['tmp_name'];
       $folder = 'images/'.$file_name;

        $max_allowed_packet = "SET GLOBAL max_allowed_packet = 1024 * 1024 * 64"; // Set to 64MB
        mysqli_query($conn, $max_allowed_packet);

        
        $price = mysqli_real_escape_string($conn, $_POST['price']);
        $author = mysqli_real_escape_string($conn, $_POST['author']);
        $method = mysqli_real_escape_string($conn, $_POST['method']);


        // Insert data into table
        $sql = "INSERT INTO selling (book_title, branch, publication, date, type, description, image,price,author,method) 
                VALUES ('$book_title', '$branch', '$publication', '$date', '$type', '$description','$file_name','$price','$author','$method')";
         if(move_uploaded_file($tempname, $folder)) {
            echo "file uploaded successfully";
         } else {
            echo "file not uploaded successfully";
         }       

        if (mysqli_query($conn, $sql)) {
            echo "Record added successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
} catch (mysqli_sql_exception $e) {
    // Handle MySQL server has gone away error
    echo "Error: " . $e->getMessage();
    // Attempt to reconnect to MySQL server
    $conn = mysqli_connect($host, $user, $pass, $db_name);
    // Retry the operation
    // Insert data into the table again
}

// Close connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Selling Form</title>
      <!--font awesome link for icons-->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="styles11.css">
</head>
<body>
     <!--navigation bar-->
     <nav id="navbar">

<div id="logo">
    <img src="BookLoop Logo.png" alt="BookLoop.com">
</div>




<ul>
    <li class="item"><a href="homepage.html"><i class="fa-solid fa-house"></i>HOME</a></li>
    <li class="item"><a href="#"><i class="fa-solid fa-user"></i>CONTACTUS</a></li>
    <li class="item"><a href="#"><i class="fa-solid fa-shop"></i>BUY</a></li>
    <li class="item"><a href="#"><i class="fa-solid fa-circle-plus"></i> SELL</a></li>
    <li class="item"><a href="#"><i class="fas fa-cart-plus"></i>CART</a></li>
</ul>

<div class="right-items">

    <form class="d-flex" role="search">
        <button class="btn btn-outline-success" type="button" id="signoutbutton"
            onclick="window.location.href = 'demo.html';">Sign out</button>
    </form>


</div>
<div class="burger">
    <div class="line"></div>
    <div class="line"></div>
    <div class="line"></div>
</div>

</nav>


<h2 id="msg"></h2>
<h2 id="greet"></h2>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
crossorigin="anonymous"></script>
<script>
let UserCreds = JSON.parse(sessionStorage.getItem("user-creds"));
let UserInfo = JSON.parse(sessionStorage.getItem("user-info"));

let MsgHead = document.getElementById('msg');
let GreetHead = document.getElementById('greet');
let Signoutbtn = document.getElementById('signoutbutton');


let Signout = () => {
    sessionStorage.removeItem("user-creds");
    sessionStorage.removeItem("user-info");
    window.location.href = 'login.html'
}

let CheckCred = () => {
    if (!sessionStorage.getItem("user-creds")) {
        //MsgHead.innerText = 'user with email "${UserCreds.email}" logged in';
        //GreetHead.innerText = 'welcome ${UserInfo.firstname +" " +UserInfo.lastname}!';
        alert(users.displayName);


    }

    else {
        window.location.href = 'login.html'
    }
}

window.addEventListener('load', CheckCred);
Signoutbtn.addEventListener('click', Signout);

document.addEventListener('DOMContentLoaded', function () {
    const burger = document.querySelector('.burger');
    const nav = document.querySelector('nav ul');

    burger.addEventListener('click', function () {
        nav.classList.toggle('nav-active');
        burger.classList.toggle('toggle');
    });
});

</script>
    <div class="container">
        <h2>Submit Book Details</h2>
        <form id="bookForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="book_title">Book Title:</label>
                <input type="text" id="book_title" name="book_title" required>
            </div>
            <div class="form-group">
                <label for="branch">Branch:</label>
                <input type="text" id="branch" name="branch" required>
            </div>
            <div class="form-group">
                <label for="publication">Publication:</label>
                <input type="text" id="publication" name="publication" required>
            </div>
            <div class="form-group">
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" required>
            </div>
            <div class="form-group">
                <label for="type">Type:</label>
                <select id="type" name="type" required>
                    <option value="negotiable">Negotiable</option>
                    <option value="non-negotiable">Non-negotiable</option>
                </select>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" required></textarea>
            </div>
           
            <div class="form-group">
                <label for="image">Image:</label>
                <input type="file" id="image" name="image" accept="image/*" required>
            </div>
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="text" id="price" name="price" required>
            </div>
            <div class="form-group">
                <label for="author">Author:</label>
                <input type="text" id="author" name="author" required>
            </div>
            <div class="form-group">
                <label for="method">Method:</label>
                <select id="method" name="method" required>
                <option value="">Select Category of book</option>
                    <option value="Medical">Medical</option>
                    <option value="Engineering">Engineering</option>
                    <option value="Magazine">Magazine</option>
                    <option value="Management book">Management book</option>
                    <option value="Stories">Stories</option>
                    <option value="School books">School books</option>
                    <option value="Others">Others</option>
                   
                </select>
            </div>

            <button type="submit">Submit</button>
        </form>
    </div>

    <script>
        // Get the form element
        var form = document.getElementById('bookForm');

        // Add event listener for form submission
        form.addEventListener('submit', function(event) {
            // Display alert when form is submitted
            alert('Form submitted successfully!');
        });
    </script>
</body>
</html>
