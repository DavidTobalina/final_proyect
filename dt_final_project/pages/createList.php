<div id="list">
    <h2>Create shopping list</h2>
    <div id="add"></div><input id="product" type="text" maxlength="20" placeholder="Add product">
    <div id="products">
        <div class="product"><img src="../images/milk.png" alt="Milk">Milk</div>
        <div class="product"><img src="../images/tomato.png" alt="Tomato">Tomato</div>
        <div class="product"><img src="../images/cheese.png" alt="Cheese">Cheese</div>
        <div class="product"><img src="../images/salad.png" alt="Salad">Salad</div>
        <div class="product"><img src="../images/chicken.png" alt="Chicken">Chicken</div>
    </div>
    <div id="cont"></div>
    <form id="items" action = "./main.php" method = "POST">
    <?php
        if(isset($_GET["err"]) and $_GET["err"] == 'true'){
            echo "<p style='color:red'>* No products selected *</p>";
        }
    ?>
        <input id="arrayCant" name="arrayCant" type="hidden">
        <input id="next" type="submit" value="Next">
    </form>
</div>