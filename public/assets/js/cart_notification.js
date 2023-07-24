// cart_notification.js

document.addEventListener('DOMContentLoaded', function () {
    const cartIcon = document.getElementById('cart-icon');
    const notification = document.getElementById('cart-notification');

    // Hide the notification initially
    notification.style.display = 'none';

    // Show the notification when an item is added to the cart
    function showNotification() {
        notification.style.display = 'block';
        notification.style.position = 'fixed';
        notification.style.top = '50px';
        notification.style.right = '20px';
        notification.style.padding = '10px';
        notification.style.backgroundColor = 'rgba(0, 0, 0, 0.8)';
        notification.style.color = 'white';
        notification.style.borderRadius = '5px';
        notification.style.zIndex = '999';
        notification.innerText = 'Item added to cart!';
        setTimeout(function () {
            notification.style.display = 'none';
        }, 2000); // Hide the notification after 2 seconds (adjust as needed)
    }

    // Listen for the 'added_to_cart' event triggered from the server-side
    document.addEventListener('added_to_cart', function (event) {
        showNotification();
    });
});
