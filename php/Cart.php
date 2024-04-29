<?php
include_once "checkDefine.php";

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
                fwrite(STDERR, "Attention, la session semble avoir été initialisé avant l'import de Cart.php");
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
}
