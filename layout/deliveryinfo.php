<?php 

$user = $_SESSION['user'];

$deliveryInfo = array(
    'fullname' => (isset($user['name']))?$user['name']:NULL,
    'addressline1' => (isset($user['addressline1']))?$user['addressline1']:NULL,
    'addressline2' => (isset($user['addressline2']))?$user['addressline2']:NULL,
    'city' => (isset($user['city']))?$user['city']:NULL,
    'state' => (isset($user['state']))?$user['state']:NULL,
    'zipcode' => (isset($user['zipcode']))?$user['zipcode']:NULL,
    'country' => (isset($user['country']))?$user['country']:NULL,
    'phone' => (isset($user['phone']))?$user['phone']:NULL,
    'deliveryinstructions' => (isset($user['deliveryinstructions']))?$user['deliveryinstructions']:NULL,
);

?>

<?php 
if($deliveryInfo['addressline1'] && isset($deliveryInfo['city']) && isset($deliveryInfo['fullname']) 
&& isset($deliveryInfo['state']) && isset($deliveryInfo['zipcode']) && isset($deliveryInfo['country']) && !isset($_GET['deliveryinfo'])):
?>
<ul class="list-unstyled">  
    <li><h4>Delivery information</h4></li>
    <li><?php echo $deliveryInfo['addressline1'] ?></li>
    <li><?php echo $deliveryInfo['addressline2'] ?></li>
    <li><?php  echo $deliveryInfo['state'].', '.$deliveryInfo['city'].' '.$deliveryInfo['zipcode'];?></li>
    <li><?php echo $deliveryInfo['country'] ?></li>
    <li><?php if(isset($deliveryInfo['phone'])){ echo 'Telefon: '.$deliveryInfo['phone']; }?></li>
</ul>
<a class="btn btn-primary" href="?pageid=account&;deliveryinfo=edit">Edit</a>

<?php endif;?>
<?php if(isset($_GET['deliveryinfo']) && $_GET['deliveryinfo'] == 'edit'):?>
<?php include('./forms/deliveryForm.php'); ?>
<?php endif;?>