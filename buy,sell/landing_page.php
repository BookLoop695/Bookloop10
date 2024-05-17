<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Books</title>
     <!--font awesome link for icons-->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="styles22.css">
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
            <li class="item"><a href="landing_page.php"><i class="fa-solid fa-shop"></i>BUY</a></li>
            <li class="item"><a href="submit_form.php"><i class="fa-solid fa-circle-plus"></i> SELL</a></li>
            <li class="item"><a href="add_to_cart.php"><i class="fas fa-cart-plus"></i>CART</a></li>
    
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
        <h1>Books</h1>
        <?php
        $host = 'localhost:3306';  
        $user = 'root';  
        $pass = '';  
        $db_name = 'buy_sell'; 

        try {
            // Establish connection
            $conn = mysqli_connect($host, $user, $pass, $db_name);  

           

            // Attempt to fetch books from the database
            $sql = "SELECT * FROM selling";
            $result = mysqli_query($conn, $sql);

            // Check if there are any books
            if (mysqli_num_rows($result) > 0) {
                // Output data of each row
                echo '<div class="books-container">';
                while($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="book">';
                    echo '<img src="images/' . $row['image'] . '" alt="' . $row['book_title'] . '">';
                    echo '<div class="book-details">';
                    echo '<h2 class="book-title">' . $row['book_title'] . '</h2>';
                    echo '<p class="book-author">Author: ' . $row['author'] . '</p>';
                    echo '<p class="book-publication">Publication: ' . $row['publication'] . '</p>';
                    echo '<p class="book-price">₹' . $row['price'] . '</p>';
                    
                    // Add to Cart button
                    echo '<form method="post" action="add_to_cart.php">';
                    echo '<input type="hidden" name="bookid" value="' . $row['bookid'] . '">';
                    echo '<button type="submit" class="add-to-cart-button">Add to Cart</button>';
                    echo '</form>';
                    echo '</div>';
                    echo '</div>';
                }
                echo '</div>'; // Close books-container
            } else {
                echo "0 results";
            }
        } catch (mysqli_sql_exception $e) {
            // Handle MySQL server has gone away error
            echo "Error: " . $e->getMessage();
        }

        // Close connection
        mysqli_close($conn);
        ?>
    </div>
</body>
</html>
