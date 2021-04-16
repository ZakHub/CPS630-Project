<?php
$id = $_POST["id"];
$model = $_POST["model"];
$rate = $_POST["rate"];

include("connect.php");

$sql = "update car set model='{$model}',rate={$rate} where id='{$id}'";


if($conn->query($sql))
{
    echo "update successfully!";
}
else
{
    echo " update failure ！";
}
