<?php
//include 'connect.php';    // shouldn't need this

class Cart
{
    protected $cartID;
    protected $trips;// = array();
    protected $products;// = array();
    protected $totalPrice;

    function __construct($choices = [])
    {
        $this->trips = array();
        $this->products = array();
        $this->totalPrice = 0;
    } 

    function getTrips()
    {
        return $this->trips;
    }
    
    function getTrip($i)
    {
        return $this->trips[$i];
    }
    
    function addTrip($trip)
    {
        array_push($this->trips, $trip);
    }

    function deleteTrip($i)
    {
        unset($this->trips[$i]);
        $this->trips = array_values($this->trips);
    }

    function getProducts()
    {
        return $this->products;
    }
    
    function getProduct($i)
    {
        return $this->products[$i];
    }
    
    function addProduct($product)
    {
        array_push($this->products, $product);
    }

    function isEmpty()
    {
        return empty($this->trips) && empty($this->products);
    }

    function getTotalPrice()
    {
        $total = 0;
        foreach ($this->products as $product) {
            $total += $product->price;
        }
        foreach ($this->trips as $trip) {
            $total += $trip->price;
        }
        return $total;
    }
}

?>
