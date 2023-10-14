Omise.setPublicKey("pkey_test_5vypcwpstt2o4dnch50");
const cart = JSON.parse(localStorage.getItem('cart')) || [];

const payOmise = () => {
    const form = document.querySelector('form[name="checkoutForm"]');
    const expirationInput = document.getElementById('exp');
    const cardHolderInput = document.getElementById('cardHolder');
    const cardNumberInput = document.getElementById('cardNumber');
    const cvvInput = document.getElementById('cvv');

    const tokenParameters = {
        "expiration_month": parseInt(expirationInput.value.split('/')[0]),
        "expiration_year": parseInt(expirationInput.value.split('/')[1]),
        "name": cardHolderInput.value,
        "number": cardNumberInput.value,
        "security_code": parseInt(cvvInput.value),
    };

    Omise.createToken("card", tokenParameters, function(statusCode, response) {
        if (statusCode === 200) {
            const cartObject = JSON.parse(localStorage.getItem('cart')) || [];
            groupOrder(cartObject);
            form.items.value = JSON.stringify(cartObject);
            form.amount.value = calculateTotal(cartObject) * 100; // จำนวนเงินในหน่วยเซนต์
            form.omiseToken.value = response.id;
            form.submit();
        } else {
            alert("Error: " + response.message);
        }
    });
}

function calculateTotal(cart) {
    return cart.reduce((total, item) => total + (parseFloat(item.price) * parseInt(item.quantity)), 0);
}

const groupOrder = (cart) => {
    return cart.reduce((cartOrder, item) => {
        if (item.quantity > 0) {
            const newItem = {
                order: [item]
            };
            cartOrder.push(newItem);
        }
        return cartOrder;
    }, []);
}

function updateCartBadge() {
    const cartBadge = document.querySelector(".badge");
    if (cartBadge) {
        cartBadge.textContent = cart.length.toString();
    }
}

function removeFromCart(index) {
    if (index >= 0 && index < cart.length) {
        cart.splice(index, 1);
        localStorage.setItem("cart", JSON.stringify(cart));
        showCart();
        updateCartBadge();
    }
}


function showCart() {
    const cartTable = document.createElement("table");
    cartTable.classList.add("cart-table");

    const tableHeader = document.createElement("thead");
    tableHeader.innerHTML = `
            <tr>
                <th>#</th>
                <th>Image</th>
                <th>Type</th>
                <th>Size</th>
                <th>Crust</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
          `;
    cartTable.appendChild(tableHeader);

    const tableBody = document.createElement("tbody");
    let cartSubtotal = 0;

    if (cart.length === 0) {
        const cartItem = document.createElement("tr");
        cartItem.innerHTML = `
              <td colspan="8">ไม่มีสินค้าในตระกร้า</td>
            `;
        tableBody.appendChild(cartItem);
    } else {
        cart.forEach((item, index) => {
            const cartItem = document.createElement("tr");
            const itemPrice = item.quantity * parseFloat(item.price);
            cartItem.innerHTML = `
                <td>${index + 1}</td>
                <td><img src="${item.imageSrc}" alt="${item.type}" width="100"></td>
                <td>${item.type}</td>
                <td>${item.size}</td>
                <td>${item.crust}</td>
                <td>
                <a href="#" class="btn btn-primary qty-control right" data-id="${item.id}" data-click="increase-qty" data-target="#qty-${item.id}">
                    <i class="fa fa-plus"></i>
                </a>
                <input type="text" name="quantity" value="${item.quantity}" class="form-control" id="qty-${item.id}" readonly/>
                <a href="#" class="btn btn-danger qty-control left" data-id="${item.id}" data-click="decrease-qty" data-target="#qty-${item.id}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash" viewBox="0 0 16 16">
                        <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z"/>
                    </svg>
                </a>
                </td>
                <td>฿${itemPrice.toFixed(2)}</td>
                <td><a href="#" onclick="removeFromCart(${index})"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash text-danger" viewBox="0 0 16 16">
                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 12v-6a.5.5 0 0 1-.5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0v-6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0v-6Z"/>
                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1 1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z"/>
                </svg></a></td>
              `;
            tableBody.appendChild(cartItem);
            cartSubtotal += itemPrice;
        });
    }

    cartTable.appendChild(tableBody);

    const cartContainer = document.getElementById("cart-container");
    cartContainer.innerHTML = ""; // เคลียร์รายการตะกร้าก่อน
    cartContainer.appendChild(cartTable);

    const itemCountBadge = document.querySelector(".badge");
    const subtotal = document.querySelector("#subtotal");
    const shipping = document.querySelector("#shipping");
    const total = document.querySelector("#total");
    itemCountBadge.textContent = cart.length.toString();
    subtotal.textContent = `฿${cartSubtotal.toFixed(2)}`;
    const shippingCost = 20; // ค่าขนส่ง
    shipping.textContent = `฿${shippingCost.toFixed(2)}`;
    total.textContent = `฿${(cartSubtotal + shippingCost).toFixed(2)}`;
}

document.addEventListener("click", function(event) {
    if (event.target && event.target.dataset.click === "increase-qty") {
        const itemId = event.target.dataset.id;
        increaseQty(itemId);
        updatePrice();
        showCart();
    }

    if (event.target && event.target.dataset.click === "decrease-qty") {
        const itemId = event.target.dataset.id;
        decreaseQty(itemId);
        updatePrice();
        showCart();
    }
});

function increaseQty(dataId) {
    const inputElement = document.querySelector(`#qty-${dataId}`);
    const currentValue = parseInt(inputElement.value);
    inputElement.value = currentValue + 1;
    updateCartBadge();
    updatePrice();
    showCart();
}

function decreaseQty(dataId) {
    const inputElement = document.querySelector(`#qty-${dataId}`);
    const currentValue = parseInt(inputElement.value);
    if (currentValue > 1) {
        inputElement.value = currentValue - 1;
        updateCartBadge();
        updatePrice();
        showCart();
    }
}

updateCartBadge();
showCart();