<?php
# Connect to the database
require('db_connect.php');
 
# Define the query to send to the database
$query_cart = 'SELECT * FROM product ORDER BY cartID';
# We use a prepared statement to execute the query
# This creates a PDOStatement object
$cart_statement = $db->prepare($query_cart);
# Execute the query
$cart_statement->execute();
# Return an array containing the query results
$cart = $cart_statement->fetchAll();
# Allows new SQL statements to execute
$cart_statement->closeCursor();
 ?>
<!DOCTYPE html>

<html lang="en">
<head>

  <title>GQZ TRAVELS - Shopping Card</title>
</head>
<body>
  <div id="outer">
    <div id="inner" class="floating">
      <h1 align="center">Shopping Cart</h1>

      <div>
      <?php foreach($cart as $cart) : ?>      
      <form method="post" action="index.php?action=add&cartID=<?php echo $cart["CartID"]; ?>">
      <div style="border:1px solid #333; background-color:#f1f1f1;" align="center">
      <h4 ><?php echo $cart["name"]; ?></h4>  
                               <h4 class="text-info">$ <?php echo $cart["name"]; ?></h4> 
                               <h4 class="text-danger">$ <?php echo $cart["price"]; ?></h4>
                               <input type="text" name="quantity" class="form-control" value="1" />  
                               <input type="hidden" name="hidden_name" value="<?php echo $cart["name"]; ?>" />  
                               <input type="hidden" name="hidden_price" value="<?php echo $cart["price"]; ?>" />  
                               <input type="submit" name="add_to_cart" style="margin-top:5px;" value="Add to Cart" />  
                          </div>  
                     </form>  
                </div>
        <?php endforeach; ?>

                <div></div>  
                <br />  
                <h3>Order Details</h3>  
                <div>  
                     <table>  
                          <tr>  
                               <th width="40%">Item Name</th>  
                               <th width="10%">Quantity</th>  
                               <th width="20%">Price</th>  
                               <th width="15%">Total</th>  
                               <th width="5%">Action</th>  
                          </tr>  
                          <?php   
                          if(!empty($_SESSION["shopping_cart"]))  
                          {  
                               $total = 0;  
                               foreach($_SESSION["shopping_cart"] as $keys => $values)  
                               {  
                          ?>  
                          <tr>  
                               <td><?php echo $values["item_name"]; ?></td>  
                               <td><?php echo $values["item_quantity"]; ?></td>  
                               <td>$ <?php echo $values["item_price"]; ?></td>  
                               <td>$ <?php echo number_format($values["item_quantity"] * $values["item_price"], 2); ?></td>  
                               <td><a href="index.php?action=delete&cartID=<?php echo $values["item_id"]; ?>"><span class="text-danger">Remove</span></a></td>  
                          </tr>  
                          <?php  
                                    $total = $total + ($values["item_quantity"] * $values["item_price"]);  
                               }  
                          ?>  
                          <tr>  
                               <td colspan="3" align="right">Total</td>  
                               <td align="right">$ <?php echo number_format($total, 2); ?></td>  
                               <td></td>  
                          </tr>  
                          <?php  
                          }  
                          ?>  
                     </table>  
                </div>  
           </div>  
           <br />  
      </body>  
 </html>
      
      
      </div>

      

    </div>
  </div>
</body>
</html>
