<?php
        require __DIR__ . '/vendor/autoload.php';

        use Automattic\WooCommerce\Client;

        $woocommerce = new Client(
            'https://baahstore.com/', // Your store URL
            'ck_75c5a8eb107c144e23bef0842d132fbbbce3b69e', // Your consumer key
            'cs_ad6b6ef056c6317ef50632f142498473c3f3fe20', // Your consumer secret
            [
                'wp_api' => true, // Enable the WP REST API integration
                'version' => 'wc/v3' // WooCommerce WP REST API version
            ]
        );
    $ordersDataPage1 = $woocommerce->get('orders?per_page=100&page=1');
    $ordersDataPage2 = $woocommerce->get('orders?per_page=100&page=2');
    $ordersDataPage3 = $woocommerce->get('orders?per_page=100&page=3');
    $totalProducts =$woocommerce->get('reports/products/totals');
    $PorcessedOrders = $woocommerce->get('reports/orders/totals');
    $customerData = $woocommerce->get('reports/customers/totals');
    $customerDataNonpaying = $customerData[1]->total;
    $porcessing_orders = $PorcessedOrders[1]->total;
    $totalProducts = $totalProducts[2]->total;
    
// Monthly Earning Progression
/*    $earningProgression;
    $thisMonthEarning = 0;
    $lastMonthEarning = 0;
    $thisMonthFirstDate = date("Y-m-d", strtotime("first day of this month"))."T00:00:00";
    $thisMonthLastDate   = date("Y-m-d", strtotime("last day of this month"))."T00:00:00";
    $lastMonthFirstDate = date("Y-m-d", strtotime("first day of last month"))."T00:00:00";
    $lastMonthLastDate =  date("Y-m-d", strtotime("last day of last month"))."T00:00:00";
    
    foreach($ordersDataPage1 as $row)
    {
        if((string)$row->date_created >= $thisMonthFirstDate and (string)$row->date_created <= $thisMonthLastDate and $row->status =='completed'){
            $thisMonthEarning = $thisMonthEarning + (int)$row->total;
        }
        if((string)$row->date_created >= $lastMonthFirstDate and (string)$row->date_created <= $lastMonthLastDate and $row->status == 'completed'){
            $lastMonthEarning = $lastMonthEarning + (int)$row->total;
        }
    }
    if($lastMonthEarning == 0)
    {
        $earningProgression = "Infinity";
    }
    else{
        $earningProgression = (($thisMonthEarning - $lastMonthEarning) / $lastMonthEarning)*100;
    }
*/
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- CSS only -->
    <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">

    <title>CheckOrderList</title>
</head>
<body>
    <div class="d-flex justify-content-center">

    
        <div class="col-xl-8 ">
            <div class="row">
                <div class="col-md-4">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                                            
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">Total Products</p>
                                    <h4 class="mb-0"><?=$totalProducts?></h4>
                                </div>
                                                            
                                <div class="flex-shrink-0 align-self-center">
                                    <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                        <span class="avatar-title">
                                        <i class="bx bx-copy-alt font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                                            
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">Orders(Processing)</p>
                                    <h4 class="mb-0"><?=$porcessing_orders?></h4>
                                </div>
                                                            
                                <div class="flex-shrink-0 align-self-center">
                                    <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                        <span class="avatar-title">
                                        <i class="bx bx-copy-alt font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                                            
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">Customer Data Non-Paying</p>
                                    <h4 class="mb-0"><?=$customerDataNonpaying?></h4>
                                </div>
                                                            
                                <div class="flex-shrink-0 align-self-center">
                                    <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                        <span class="avatar-title">
                                        <i class="bx bx-copy-alt font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <div class="row">
        <br></br>
        <div class="container table-responsive{-sm|-md|-lg|-xl}">
                <table id ="orderList" class=" table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Order Number</th>
                            <th scope="col">Order</th>
                            <th scope="col">Date</th>
                            <th scope="col">Status</th>
                            <th scope="col">Total</th> 
                            <th scope="col">View Details</th>   
                        </tr>
                    </thead>
                    <tbody>
                        
                        <?php for ($i = 0; $i<count($ordersDataPage1);  $i++){?>
                        <tr> 
                            <td> <?= $ordersDataPage1[$i]->id ;?></td>
                            <td><?= $ordersDataPage1[$i]->billing->first_name;?></td>
                            <td ><?=  $ordersDataPage1[$i]->date_created;?> </td >
                            <td>
                                <button class="btn
                                <?php 
                                    if($ordersDataPage1[$i]->status == 'completed') 
                                        echo'btn-success'; 
                                    elseif ($ordersDataPage1[$i]->status =='pending' ) {
                                        echo'btn-info';
                                    }
                                    elseif ($ordersDataPage1[$i]->status =='processing' ) {
                                        echo'btn-primary';
                                    }
                                    elseif($ordersDataPage1[$i]->status == 'cancelled'){
                                        echo'btn-danger';
                                    }
                                    elseif($ordersDataPage1[$i]->status == 'refunded'){
                                        echo'btn-dark';}
                                    elseif($ordersDataPage1[$i]->status == 'on-hold'){
                                        echo' btn-warning';}
                                    elseif($ordersDataPage1[$i]->status == 'draft'){
                                        echo' btn-warning';
                                    }
                                    ?> " style="cursor:text" >

                                    
                                    
                                    <?=  $ordersDataPage1[$i]->status;?></button>
                            </td>
                            <td ><?=  $ordersDataPage1[$i]->total;?> </td >
                            <td >
                            <a class="btn btn-outline-primary"  href="viewDetails.php?varname=<?=  $ordersDataPage1[$i]->id ;?>">ViewDetails</a>
                            </td>
                        </tr> 
                        <?php }; ?>
                        <?php for ($i = 0; $i<count($ordersDataPage2);  $i++){?>
                        <tr> 
                            <td> <?= $ordersDataPage2[$i]->id ;?></td>
                            <td><?= $ordersDataPage2[$i]->billing->first_name;?></td>
                            <td ><?=  $ordersDataPage2[$i]->date_created;?> </td >
                            <td>
                                <button class="btn
                                <?php 
                                    if($ordersDataPage2[$i]->status == 'completed') 
                                        echo'btn-success'; 
                                    elseif ($ordersDataPage2[$i]->status =='pending' ) {
                                        echo'btn-info';
                                    }
                                    elseif ($ordersDataPage2[$i]->status =='processing' ) {
                                        echo'btn-primary';
                                    }
                                    elseif($ordersDataPage2[$i]->status == 'cancelled'){
                                        echo'btn-danger';
                                    }
                                    elseif($ordersDataPage2[$i]->status == 'refunded'){
                                        echo'btn-dark';}
                                    elseif($ordersDataPage2[$i]->status == 'on-hold'){
                                        echo' btn-warning';}
                                    elseif($ordersDataPage2[$i]->status == 'draft'){
                                        echo' btn-warning';
                                    }                                    
                                    ?> " style="cursor:text" >
                                    
                                    <?=  $ordersDataPage2[$i]->status;?></button>
                            </td>
                            <td ><?=  $ordersDataPage2[$i]->total;?> </td >
                            <td >
                            <a class="btn btn-outline-primary"  href="viewDetails.php?varname=<?=  $ordersDataPage2[$i]->id ;?>">ViewDetails</a>
                            </td>
                        </tr> 
                        <?php }; ?>
                        <?php for ($i = 0; $i<count($ordersDataPage3);  $i++){?>
                        <tr> 
                            <td> <?= $ordersDataPage3[$i]->id ;?></td>
                            <td><?= $ordersDataPage3[$i]->billing->first_name;?></td>
                            <td ><?=  $ordersDataPage3[$i]->date_created;?> </td >
                            <td>
                                <button class="btn
                                <?php 
                                    if($ordersDataPage3[$i]->status == 'completed') 
                                        echo'btn-success'; 
                                    elseif ($ordersDataPage3[$i]->status =='pending' ) {
                                        echo'btn-info';
                                    }
                                    elseif ($ordersDataPage3[$i]->status =='processing' ) {
                                        echo'btn-primary';
                                    }
                                    elseif($ordersDataPage3[$i]->status == 'cancelled'){
                                        echo'btn-danger';
                                    }
                                    elseif($ordersDataPage3[$i]->status == 'refunded'){
                                        echo'btn-dark';}
                                    elseif($ordersDataPage3[$i]->status == 'on-hold'){
                                        echo' btn-warning';}
                                    elseif($ordersDataPage3[$i]->status == 'draft'){
                                        echo' btn-warning';
                                    }                                   
                                    ?> " style="cursor:text" >
                                    
                                    <?=  $ordersDataPage3[$i]->status;?></button>
                            </td>
                            <td ><?=  $ordersDataPage3[$i]->total;?> </td >
                            <td >
                            <a class="btn btn-outline-primary"  href="viewDetails.php?varname=<?=  $ordersDataPage3[$i]->id ;?>">ViewDetails</a>
                            </td>
                        </tr> 
                        <?php }; ?>
                    
                    </tbody>
                </table>
        </div>
    </div>
                                </div>
    </div>                                 


    



<!-- JavaScript Bundle with Popper -->

<script language="JavaScript" type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
<script type="text/javascript" src = "https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src = "https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src = "https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
    $('#orderList').DataTable();
} );
</script>
</body>
</html>