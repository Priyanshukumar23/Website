<?php
include 'config/db.php';
session_start();

// Check if user is logged in
$isLoggedIn = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Kumar Brothers</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .navbar {
            background-color: #333;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }
        .logo {
            color: white;
            font-size: 1.5rem;
            font-weight: bold;
            text-decoration: none;
        }
        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }
        .nav-links a {
            color: white;
            text-decoration: none;
            transition: color 0.3s;
        }
        .nav-links a:hover {
            color: #007bff;
        }
        .profile-dropdown {
            position: relative;
        }
        .profile-icon {
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .profile-icon i {
            font-size: 1.5rem;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background: white;
            min-width: 200px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
            border-radius: 4px;
            z-index: 1;
        }
        .profile-dropdown:hover .dropdown-content {
            display: block;
        }
        .dropdown-content a {
            color: #333;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            transition: background-color 0.3s;
        }
        .dropdown-content a:hover {
            background-color: #f8f9fa;
            color: #007bff;
        }
        .dropdown-content a i {
            margin-right: 8px;
            width: 20px;
            text-align: center;
        }
        .main-content {
            margin-top: 80px;
            padding: 2rem;
        }
        .cart-container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .cart-items {
            display: grid;
            gap: 2rem;
        }
        .cart-item {
            display: flex;
            gap: 2rem;
            padding: 1.5rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        .cart-item img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
        }
        .cart-item-details {
            flex: 1;
        }
        .cart-item-title {
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
            color: #333;
        }
        .cart-item-price {
            font-size: 1.3rem;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 1rem;
        }
        .cart-item-quantity {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .quantity-btn {
            background: #f8f9fa;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .quantity-btn:hover {
            background: #e9ecef;
        }
        .remove-btn {
            background: #dc3545;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .remove-btn:hover {
            background: #c82333;
        }
        .cart-summary {
            margin-top: 2rem;
            padding: 1.5rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
        }
        .checkout-btn {
            background: #007bff;
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 5px;
            font-size: 1.1rem;
            cursor: pointer;
            width: 100%;
            transition: background 0.3s;
        }
        .checkout-btn:hover {
            background: #0056b3;
        }
        .empty-cart {
            text-align: center;
            padding: 3rem;
        }
        .empty-cart i {
            font-size: 4rem;
            color: #ddd;
            margin-bottom: 1rem;
        }
        .empty-cart h2 {
            color: #666;
            margin-bottom: 1rem;
        }
        .empty-cart p {
            color: #999;
            margin-bottom: 2rem;
        }
        .shop-btn {
            background: #007bff;
            color: white;
            padding: 1rem 2rem;
            border: none;
            border-radius: 5px;
            font-size: 1.1rem;
            cursor: pointer;
            transition: background 0.3s;
        }
        .shop-btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="index.php" class="logo">Kumar Brothers</a>
        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="men.php">Men</a>
            <a href="women.php">Women</a>
            <a href="kids.php">Kids</a>
            <a href="cart.php"><i class="fas fa-shopping-cart"></i> Cart</a>
            <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
                <div class="profile-dropdown">
                    <div class="profile-icon">
                        <i class="fas fa-user-circle"></i>
                        <span>My Profile</span>
                    </div>
                    <div class="dropdown-content">
                        <a href="profile.php"><i class="fas fa-user"></i> My Profile</a>
                        <a href="edit_profile.php"><i class="fas fa-edit"></i> Edit Profile</a>
                        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </div>
                </div>
            <?php else: ?>
                <a href="login.php">Login</a>
                <a href="register.php">Register</a>
            <?php endif; ?>
        </div>
    </nav>

    <main class="main-content">
        <div class="cart-container">
            <h1>Your Cart</h1>
            <div id="cart-items" class="cart-items">
                <!-- Cart items will be loaded here -->
            </div>
            <div id="cart-summary" class="cart-summary">
                <!-- Cart summary will be loaded here -->
            </div>
        </div>
    </main>

    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h3>About Us</h3>
                <p>Kumar Brothers - Your trusted fashion partner since 1990</p>
            </div>
            <div class="footer-section">
                <h3>Contact Us</h3>
                <p>Email: info@kumarbrothers.com</p>
                <p>Phone: +91 1234567890</p>
            </div>
            <div class="footer-section">
                <h3>Follow Us</h3>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 Kumar Brothers. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Load cart items from localStorage
        function loadCart() {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            const cartItemsContainer = document.getElementById('cart-items');
            const cartSummaryContainer = document.getElementById('cart-summary');

            if (cart.length === 0) {
                cartItemsContainer.innerHTML = `
                    <div class="empty-cart">
                        <i class="fas fa-shopping-cart"></i>
                        <h2>Your cart is empty</h2>
                        <p>Looks like you haven't added any items to your cart yet.</p>
                        <a href="index.php" class="shop-btn">Continue Shopping</a>
                    </div>
                `;
                cartSummaryContainer.style.display = 'none';
                return;
            }

            let total = 0;
            let itemsHtml = '';

            cart.forEach((item, index) => {
                total += item.price * item.quantity;
                itemsHtml += `
                    <div class="cart-item">
                        <img src="${item.imagePath}" alt="${item.name}" style="width: 150px; height: 150px; object-fit: cover;">
                        <div class="cart-item-details">
                            <h3 class="cart-item-title">${item.name}</h3>
                            <p class="cart-item-price">₹${item.price}</p>
                            <div class="cart-item-quantity">
                                <button class="quantity-btn" onclick="updateQuantity(${index}, -1)">-</button>
                                <span>${item.quantity}</span>
                                <button class="quantity-btn" onclick="updateQuantity(${index}, 1)">+</button>
                                <button class="remove-btn" onclick="removeItem(${index})">Remove</button>
                            </div>
                        </div>
                    </div>
                `;
            });

            cartItemsContainer.innerHTML = itemsHtml;
            cartSummaryContainer.innerHTML = `
                <div class="summary-row">
                    <span>Subtotal</span>
                    <span>₹${total}</span>
                </div>
                <div class="summary-row">
                    <span>Shipping</span>
                    <span>Free</span>
                </div>
                <div class="summary-row">
                    <span>Total</span>
                    <span>₹${total}</span>
                </div>
                <button class="checkout-btn" onclick="checkout()">Proceed to Checkout</button>
            `;
        }

        function updateQuantity(index, change) {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            cart[index].quantity += change;
            
            if (cart[index].quantity < 1) {
                cart[index].quantity = 1;
            }
            
            localStorage.setItem('cart', JSON.stringify(cart));
            loadCart();
        }

        function removeItem(index) {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            cart.splice(index, 1);
            localStorage.setItem('cart', JSON.stringify(cart));
            loadCart();
        }

        function checkout() {
            if (!<?php echo isset($_SESSION['logged_in']) ? 'true' : 'false'; ?>) {
                alert('Please login to proceed with checkout');
                window.location.href = 'login.php';
                return;
            }
            
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            if (cart.length === 0) {
                alert('Your cart is empty');
                return;
            }

            // Create a form to submit cart data
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'checkout.php';
            
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'cart';
            input.value = JSON.stringify(cart);
            
            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
        }

        // Load cart when page loads
        loadCart();
    </script>
</body>
</html> 