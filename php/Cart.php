<?php
require_once "Product.php";
require_once "OptionArray.php";


class Cart implements Iterator {
    private Array $products;
    private Array $productsQuantity;
    private Array $productOption; // Array of OptionArray
    private int $position = 0;

    public function __construct() {
        $this->products = array();
        $this->productsQuantity = array();
        $this->productOption = array();
    }

    public function __toString(): string {
        return "Cart object";
    }

    public static function getUserCart(): Cart {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION["cart"]) || !$_SESSION["cart"] instanceof Cart) {
            if (isset($_SESSION["cart"]) && get_class($_SESSION["cart"]) === "__PHP_Incomplete_Class")
                error_log("Attention, la session semble avoir été initialisé avant l'import de Cart.php");
            $_SESSION["cart"] = new Cart();
        }
        return $_SESSION["cart"];
    }

    //Iterator function
    public function current(): mixed {
        return array(
            "product" => clone $this->products[$this->position],
            "quantity" => $this->productsQuantity[$this->position],
            "optionArray" => $this->productOption[$this->position]
        );
    }

    public function key(): int {
        return $this->position;
    }

    public function next(): void {
        ++$this->position;
    }

    public function rewind(): void {
        $this->position = 0;
    }

    public function valid(): bool {
        return isset($this->products[$this->position]);
    }

    // Getteur
    public function getSize(): int {
        return sizeof($this->products);
    }

    /**
     * Search a product in the cart, if option are specify check also the option
     * @param Product $product The product
     * @param OptionArray $option The option of the product, if null dont check them
     * @return int|false The position of the product in the cart, false if the product isn't in the cart
     */
    public function searchProduct(Product $product, OptionArray $option = null): int|false {
        $i = 0;
        while ($i < count($this -> products)) {
            if ($this->products[$i] == $product && ($option === null || $this->productOption[$i] == $option))
                return $i;
            $i++;
        }

        return false;
    }

    /**
     * This function can be use to add or remove an element in the cart
     * If the product have an negative or null quantity, remove 
     */
    public function addIntoCart(Product $product, int $quantity, OptionArray $arrayOption) {
        $pos = $this -> searchProduct($product, $arrayOption);
        if ($pos === false) {
            array_push($this->products, $product);
            array_push($this->productsQuantity, 0);
            array_push($this->productOption, $arrayOption);
            $pos = sizeof($this->productsQuantity) - 1;
        }

        $this->productsQuantity[$pos] += $quantity;

        // Remove if the product isn't in the cart anymore
        if ($this->productsQuantity[$pos] <= 0){
            array_splice($this->products, $pos, 1);
            array_splice($this->productsQuantity, $pos, 1);
            array_splice($this->productOption, $pos, 1);
        }
    }

    public function count(): int {
        return count($this->products);
    }

    public function isEmpty(): bool {
        return $this -> count() === 0;
    }

    /**
     * This function remove all product from the cart
     */
    public function emptyCart(): void {
        $this->products = array();
        $this->productsQuantity = array();
        $this->productOption = array();
    }

    /**
     * Check if the cart is purchasable
     * In other word, this methods check if all the product in the cart are in stock (depend of the quantity in the cart)
     * @return bool false if at least one product isn't in stock, true if all the product are in stock
     */
    public function isPurchasable(): bool {
        foreach ($this as $product) {
            if ($product["product"]->getQuantityInStock() < $product["quantity"])
                return false;
        }
        return true;
    }

    /**
     * This function return the total price of the cart
     * @return float The total price of the cart
     */
    public function getTotalPrice(): float {
        $total = 0;
        foreach ($this as $product) {
            $optionCost = 0;
            foreach ($product["optionArray"] as $option) {
                $optionCost += $option->getPrice();
            }
            $total += ($product["product"]->getPrice() + $optionCost) * $product["quantity"];
        }
        return $total;
    }

    /**
     * This function is use to purchase the cart
     * This function will check if the cart is valid
     * @param int $idClient The client id
     */
    public function purchase(int $idClient, string $paymentMode, array $infoFacturation, array $infoLivraison, array $livraisonCoord) {
        if ($this -> isEmpty())
            throw new Exception("Cart is empty");

        if ($this -> isPurchasable() === false)
            throw new Exception("Some product are out of stock");

        $produitId = array();
        $produitQuantite = array();
        $produitOption = array();
        foreach ($this as $product) {
            array_push($produitId, $product["product"]->getId());
            array_push($produitQuantite, $product["quantity"]);
            array_push($produitOption, $product["optionArray"]->getIds());
        }

        // Everything should be good, we can now purchase the cart content
        creerCommande($idClient, $paymentMode, $produitId, $produitQuantite, $infoFacturation, $infoLivraison, $livraisonCoord, $produitOption);
    }

    /**
     * This function return the quantity of a product in the cart
     * @param Product $product The product
     * @param OptionArray $option The option of the product
     * @return int The quantity of the product in the cart
     */
    public function getQuantity(Product $product, OptionArray $option): int {
        $pos = $this -> searchProduct($product, $option);
        if ($pos === false)
            return 0;
        return $this -> productsQuantity[$pos];
    }
}
