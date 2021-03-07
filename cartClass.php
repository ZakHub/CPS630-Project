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

    function gettrips(){}
    
    function addTrip($trip)
    {
        array_push($this->trips, $trip);
    }

    function getproduct(){}
    
    function addProduct($product)
    {
        array_push($this->products, $product);
    }

    function isEmpty()
    {
        return empty($this->trips) && empty($this->products);
    }

    function getTotalPrice(){}

    function getTotaltrips(){}

    function getTotalProducts(){}






}

?>
