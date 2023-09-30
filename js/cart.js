// Initialize the cart array from localStorage if available, or create an empty array
const cart = JSON.parse(localStorage.getItem('cart')) || [];

// Function to add a pizza to the cart
function addToCart() {
    const pizzaType = document.getElementById("pizza-type").value;
    const pizzaSize = document.querySelector('input[name="pizza-size"]:checked').value;
    const pizzaCrust = document.getElementById("pizza-crust").value;

    const pizzaOrder = {
        type: pizzaType,
        size: pizzaSize,
        crust: pizzaCrust,
        quantity: 1, // Initialize quantity to 1
    };

    // Check if the same pizza is already in the cart
    const existingPizzaIndex = cart.findIndex((item) => {
        return (
            item.type === pizzaOrder.type &&
            item.size === pizzaOrder.size &&
            item.crust === pizzaOrder.crust
        );
    });

    if (existingPizzaIndex !== -1) {
        // If the same pizza is found in the cart, increase its quantity
        cart[existingPizzaIndex].quantity++;
    } else {
        // Otherwise, add the pizza to the cart
        cart.push(pizzaOrder);
    }

    alert("Added to Cart!");
    // Save the updated cart to localStorage
    localStorage.setItem('cart', JSON.stringify(cart));
    showCart(); // Update the cart display
}

// Function to remove a pizza from the cart
function removeFromCart(index) {
    if (index >= 0 && index < cart.length) {
        cart.splice(index, 1); // Remove the pizza at the specified index
        // Save the updated cart to localStorage
        localStorage.setItem('cart', JSON.stringify(cart));
        showCart(); // Update the cart display
    }
}

// Function to display the cart items
function showCart() {
    const cartContainer = document.getElementById("cart-container");
    cartContainer.innerHTML = ""; // Clear previous cart items

    if (cart.length === 0) {
        cartContainer.innerHTML = "<p>Your cart is empty.</p>";
    } else {
        cart.forEach((item, index) => {
            const cartItem = document.createElement("div");
            cartItem.classList.add("cart-item");
            cartItem.innerHTML = `
                <p>Item #${index + 1}</p>
                <p>Type: ${item.type}</p>
                <p>Size: ${item.size}</p>
                <p>Crust: ${item.crust}</p>
                <p>Quantity: ${item.quantity}</p>
                <button onclick="removeFromCart(${index})">Remove</button>
            `;
            cartContainer.appendChild(cartItem);
        });
    }
}

// Initial call to showCart to load cart items from localStorage on page load
showCart();
