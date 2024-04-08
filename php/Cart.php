<?php
require_once "Product.php";

class Cart implements Iterator {
    private Array $products;
    private Array $productsQuantity;
    private int $position = 0;

    public function __construct() {
        $this->products = array();
        $this->productsQuantity = array();
    }

    public function __toString(): string {
        return "Cart object";
    }

    public static function getUserCart(): Cart {
        if (session_status() == PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION["cart"]) || !$_SESSION["cart"] instanceof Cart)
            $_SESSION["cart"] = new Cart();
        return $_SESSION["cart"];
    }

    //Iterator function
    public function current(): mixed {
        return array(
            "product" => clone $this->products[$this->position],
            "quantity" => $this->productsQuantity[$this->position],
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
     * This function can be use to add or remove an element in the cart
     * If the product have an negative or null quantity, remove 
     */
    public function addIntoCart(Product $product, int $quantity) {
        $pos = array_search($product, $this->products, false);
        if ($pos === false) {
            array_push($this->products, $product);
            array_push($this->productsQuantity, 0);
            $pos = sizeof($this->productsQuantity) - 1;
        }

        $this->productsQuantity[$pos] += $quantity;

        // Remove if the product isn't in the cart anymore
        if ($this->productsQuantity[$pos] <= 0){
            array_splice($this->products, $pos, 1);
            array_splice($this->productsQuantity, $pos, 1);
        }
    }
}
