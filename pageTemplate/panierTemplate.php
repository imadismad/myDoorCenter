<?php
require_once __DIR__."/../php/Cart.php";
if (session_status() === PHP_SESSION_NONE) session_start();
$cart = Cart::getUserCart();
?>

<table class="table">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Quantité</th>
            <th>Prix unitaire HT</th>
            <th>TVA (20%)</th>
            <th>Prix total TTC</th>
        </tr>
    </thead>
    <tbody id="cartTable">
        <?php
            foreach ($cart as $value) {
                $product = $value["product"];
                $quantity = $value["quantity"];
                $optionArray = $value["optionArray"];

                $stock = $product -> getQuantityInStock();
                $maxQuantity = $stock - $cart -> getQuantityById($product -> getId()) + $quantity;

                $totHT = $quantity * $product->getUnitaryPrice();
                $totTVA = $totHT * 0.2;
                $totTTC = $totHT + $totTVA;
                $totOption = 0;

                $quantityOption = $optionArray -> count();

                echo
                "<tr>"
                    ."<td>".$product->getName().
                    "<ul>";
                    
                    
                    for ($i = 0; $i < $quantityOption   ; $i++) {
                        echo "<li>".$optionArray->get($i)->getLibele().
                        " (".$optionArray->get($i)->getPrice()." &euro;)"."</li>";
                        $totOption += $optionArray->get($i)->getPrice();
                    }
                    
                    echo "</ul></td>"
                    .'<td><input type="number" value="'.$quantity.'" name="'.$product->getId().'" data-option-ids="'.$optionArray -> toIdsRequete().'" max="'.$maxQuantity.'" data-stock="'.$stock.'"></td>'
                    ."<td>".$product->getUnitaryPrice()."</td>"
                    ."<td>".$totTVA."</td>"
                    ."<td>".($totTTC + $totOption * $quantity)."</td>"
                ."</tr>";
            }
        ?>
    </tbody>
</table>