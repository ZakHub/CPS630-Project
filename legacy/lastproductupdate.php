<?php
$id = $_POST["id"];
$description = $_POST["description"];
$storeId = $_POST["storeId"];

include("connect.php");

$sql = "update product set description='{$description}',storeId={$storeId} where id='{$id}'";


if($conn->query($sql))
{
    echo "update successfully!";
}
else
{
    echo " update failure ！";
}
