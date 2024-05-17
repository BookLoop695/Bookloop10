<?php
session_start();

$host = 'localhost:3306';
$user = 'root';
$pass = '';
$db_name = 'buy_sell';

$message = '';

try {
    // Establish connection
    $conn = mysqli_connect($host, $user, $pass, $db_name);

    // Check if bookid is provided
    if (isset($_POST['bookid'])) {
        $bookid = $_POST['bookid'];

        // Fetch book details from the database
        $sql = "SELECT * FROM selling WHERE bookid = $bookid";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            // Book found, add it to the cart
            $row = mysqli_fetch_assoc($result);

            // Add the book details to the cart session
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = array();
            }
            $_SESSION['cart'][] = $row;

            $message = "Book added to cart successfully!";
        } else {
            $message = "Book not found!";
        }
    } else {
        $message = "Invalid request!";
    }

    // Check if removing a book from the cart
    if (isset($_POST['remove_bookid'])) {
        $removeBookId = $_POST['remove_bookid'];
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $key => $item) {
                if ($item['bookid'] == $removeBookId) {
                    unset($_SESSION['cart'][$key]);
                    $message = "Book removed from cart.";
                    break;
                }
            }
            // Re-index the array to ensure correct indices
            $_SESSION['cart'] = array_values($_SESSION['cart']);
        }
    }
} catch (mysqli_sql_exception $e) {
    // Handle MySQL server has gone away error
    $message = "Error: " . $e->getMessage();
}

// Close connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add to Cart</title>
     <!--font awesome link for icons-->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="cartdesign.css">
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
                <button class="btn btn-outline-success" type="button" id="signoutbutton" onclick="window.location.href = 'demo.html';">Sign out</button>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
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


            } else {
                window.location.href = 'login.html'
            }
        }

        window.addEventListener('load', CheckCred);
        Signoutbtn.addEventListener('click', Signout);

        document.addEventListener('DOMContentLoaded', function() {
            const burger = document.querySelector('.burger');
            const nav = document.querySelector('nav ul');

            burger.addEventListener('click', function() {
                nav.classList.toggle('nav-active');
                burger.classList.toggle('toggle');
            });
        });
    </script>


    <div class="container">
        <h1>Cart</h1>
        <div id="message">
            <?php echo $message; ?>
        </div>


        <div class="cart-items">
            <?php

            $totalPrice = 0.00; // Initialize total price

            // Display cart items
            if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
                foreach ($_SESSION['cart'] as $item) {
                    echo '<div class="book">';
                    echo '<div class="book-details">';
                    echo '<h2 class="book-title">' . $item['book_title'] . '</h2>';
                    echo '<p class="book-author">Author: ' . $item['author'] . '</p>';
                    echo '<p class="book-publication">Publication: ' . $item['publication'] . '</p>';
                    echo '<p class="book-price">₹' . $item['price'] . '</p>';
                    $totalPrice += (float)$item['price'];
                    echo '</div>';
                    echo '<form action="buy_item.php" method="post">';
                    echo '<input type="hidden" name="bookid" value="' . $item['bookid'] . '">';
                    echo '<button type="submit" class="buy-button">Buy</button>';
                    echo '</form>';
                    echo '<form action="" method="post">';
                    echo '<input type="hidden" name="remove_bookid" value="' . $item['bookid'] . '">';
                    echo '<button type="submit" class="delete-button">Delete</button>';
                    echo '</form>';
                    echo '</div>';
                }
            } else {
                echo '<p>No items in the cart.</p>';
            }
            ?>
        </div>

        <div class="total-price">
            <h2>Total Price: ₹<?php echo number_format($totalPrice, 2); ?></h2>
        </div>

       


        <a href="landing_page.php">Back to Books</a> <!-- Link to go back to the book listing page -->
    </div>
</body>

</html>