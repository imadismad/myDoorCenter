<?php
require_once __DIR__."/../php/Cart.php";
$cart = Cart::getUserCart();
?>

<table>
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

                $totHT = $quantity * $product->getUnitaryPrice();
                $totTVA = $totHT * 0.2;
                $totTTC = $totHT + $totTVA;
                echo
                "<tr>"
                    ."<td>".$product->getName()."</td>"
                    ."<td><input type=\"number\" value=\"".$quantity."\"></td>"
                    ."<td>".$totTVA."</td>"
                    ."<td>".$totTTC."</td>"
                ."</tr>";
            }
        ?>
    </tbody>
</table>