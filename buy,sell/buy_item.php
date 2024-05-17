<?php
session_start();

if (isset($_POST['bookid'])) {
    $bookid = $_POST['bookid'];

    // Find the book details in the cart
    $selectedBook = null;
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            if ($item['bookid'] == $bookid) {
                $selectedBook = $item;
                break;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy Item</title>
    <!--font awesome link for icons-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
        <h1>Confirm Booking for <?php echo htmlspecialchars($selectedBook['book_title']); ?></h1>

        <form action="process_payment.php" method="post">
            <input type="hidden" name="bookid" value="<?php echo $selectedBook['bookid']; ?>">
            <input type="hidden" name="price" value="<?php echo $selectedBook['price']; ?>">
            <button type="submit" class="pay-button">Confirm Booking</button>
        </form>

        <div class="back-button">
            <a href="add_to_cart.php">Back to Cart</a>
        </div>
    </div>
</body>

</html>