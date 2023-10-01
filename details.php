<?php require 'haeder.php'; ?>

<!-- Pizza Ordering Form -->
<div class="container mt-5">
    <h1 class="text-center">Pizza Ordering System</h1>
    <form id="pizza-order-form" class="mt-4">
        <!-- Pizza Options -->
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="pizza-option">
                    <img src="images/pizza-1.jpg" alt="Margherita Pizza" class="pizza-image">
                    <label>
                        <input type="radio" name="pizza-type" value="margherita" class="form-check-input">
                        Margherita
                    </label>
                </div>
            </div>
        </div>
        <!-- Select Pizza Size -->
        <div class="mb-3">
            <label class="form-label">Select Pizza Size:</label>
            <div class="form-check">
                <input type="radio" id="small" name="pizza-size" value="small" class="form-check-input">
                <label for="small" class="form-check-label">Small</label>
            </div>
            <div class="form-check">
                <input type="radio" id="medium" name="pizza-size" value="medium" class="form-check-input">
                <label for="medium" class="form-check-label">Medium</label>
            </div>
            <div class="form-check">
                <input type="radio" id="large" name="pizza-size" value="large" class="form-check-input">
                <label for="large" class="form-check-label">Large</label>
            </div>
        </div>
        <!-- Select Pizza Crust -->
        <div class="mb-3">
            <label for="pizza-crust" class="form-label">Select Pizza Crust:</label>
            <select id="pizza-crust" name="pizza-crust" class="form-select">
                <option value="thin">Thin Crust</option>
                <option value="pan">Pan Crust</option>
                <option value="stuffed">Stuffed Crust</option>
                <!-- Add more crust options as needed -->
            </select>
        </div>
        <!-- Add to Cart Button -->
        <button type="button" onclick="addToCart()" class="btn btn-warning">Add to Cart</button>
    </form>
</div>

<?php require 'footer.php'; ?>