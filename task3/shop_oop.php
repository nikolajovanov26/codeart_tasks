<?php

/**
 * Да се дополнат класите така што ќе се случи следново сценарио:
 *
 * 1. John ќе си ја наполни кошничката со продуктите кои се веќе иницијализирани во променливата $products
 * 2. За да купи што е можно повеќе производи John одлучил дека ќе ги сортира производите во кошницата по цена по
 *    опаѓачки редослед и ќе ги купува еден по еден додека има пари.
 * 3. Откако John ќе заврши со купувањето да се испечати кои производи му останале на John во кошницата и да се испечати
 *    уште колку пари му останале.
 *
 * Напомена: Може да се додаваат методи во класите но стартниот код не смее да се менува.
 */

class Product
{
    /**
     * @param  int  $id
     * @param  string  $name
     * @param  float  $price
     */
    public function __construct(
        public int $id,
        public string $name,
        public float $price
    ) {}
}

class Cart
{
    /**
     * @param  Product[] $products
     */
    public function __construct(
        private array $products
    ) {}

    /**
     * Sort the products in the cart in descending order by price
     *
     * @return void
     */
    public function sortByPrice(): void
    {
      array_multisort(array_column($this->products, 'price'), SORT_DESC, $this->products);
    }

    /**
     * Add products to the cart
     * @param  Product[] $products
     * @return void
     */
    public function addProducts($products): void
    {
      $this->products = array_merge($this->products, $products);
    }

    /**
     * Get a product from the cart
     *
     * @return Product
     */
    public function getProduct($money): ?Product
    {
      if(!empty($this->products)){
        $product = end($this->products);
        if($product->price <= $money){
          $product = array_pop($this->products);
          return $product;
        }
      }
      return null;
    }

    /**
     * Get all products
     *
     * @return Product[]
     */
    public function getAllProduct(): array
    {
      return $this->products;
    }
}

class Buyer
{
    /**
     * @param  string  $name
     * @param  Cart  $cart
     * @param  float  $money
     */
    public function __construct(
        public string $name,
        public Cart $cart,
        private float $money
    ) {}

    /**
     * @return void
     */
     public function buyProducts(): void
     {
       if($product = $this->cart->getProduct($this->money)){
         $price = $product->price;
         $this->money -= $product->price;
         $this->buyProducts($this->money);
       }else{
         $this->cart->getProduct($this->money);
       }
     }

    /**
     * @return void
     */
    public function printRemainingCartProducts(): void
    {
      $products = $this->cart->getAllProduct();
      if(!empty($products)){
        echo 'Items left in the cart: <br>';

        ?>
        <table cellspacing="15">
          <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Price</th>
          </tr>

        <?php
        foreach ($products as $key => $value) {
          echo'<tr>
            <td>'.$value->id.'</td>
            <td>'.$value->name.'</td>
            <td>'.$value->price.'</td>
          </tr>';
        }
        ?> </table> <?php
        echo '<hr>';
      }
    }

    /**
     * @return void
     */
    public function printRemainingMoney(): void
    {
      echo 'Money left: '.$this->money;
    }

}

$products = [
  new Product(1, "banana", 4.99),
  new Product(2, "apple", 9.55),
  new Product(3, "ice cream", 12),
  new Product(4, "yogurt", 13),
  new Product(5, "yogurt", 14)
];

$buyer = new Buyer("John", new Cart([]), 43.99);
$buyer->cart->addProducts($products);
$buyer->cart->sortByPrice();
//var_dump($buyer);

/**
 * Results
 */
$buyer->buyProducts();
$buyer->printRemainingCartProducts();
$buyer->printRemainingMoney();
