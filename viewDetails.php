<?php
// Install:
// composer require automattic/woocommerce

// Setup:
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
    if(!isset( $_GET['varname'])){
        header('Location: http://localhost/API%20Integration/CheckOrderList.php');
    }
    else
    {
        if(empty($_GET['varname']))
        {
            header('Location: http://localhost/API%20Integration/CheckOrderList.php');
        }
        else{
            $orderid = $_GET['varname'];
            $orders = $woocommerce->get('orders/'.$orderid);
           // echo($orders->line_items[0]->name);   
            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <!-- CSS only -->
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
                <title>Order Details</title>
                <style>
                    @media screen and (min-width: 480px) {
                        .justify-conten-center{
                            max-width: 50%;
                            margin:auto;
                        }
                    }
                </style>

            </head>
            <body>
                <br>
                <table class="justify-conten-center  table table-secondary  table-hover">
                    <thead>
                    <tr>
                            <th scope="col">Billing Name</th>
                            <th scope="col">Order Number</th>

                        </tr>
                        <tr>
                            <th scope=""col><?=$orders->billing->first_name; ?></th>
                            <th scope=""col><?=$orders->id; ?></th>
                        </tr>
                    </thead>
                </table>
                <table class=" table table-secondary  table-hover justify-conten-center ">
                    <thead>
                        <tr>
                            <th scope="col">Product Name</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Price</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            for($i = 0; $i<count($orders->line_items); $i++){
                               echo"<tr>";
                               echo"<td>". $orders->line_items[$i]->name."</td>";
                               echo"<td>". $orders->line_items[$i]->quantity."</td>";
                               echo"<td>". $orders->line_items[$i]->total."</td>";
                               echo"<tr>";
                            }
                            echo"<tr><td class='fw-bolder'>Shiping Cost:</td><td></td><td class='fw-bolder'>".$orders->shipping_total."</td></tr>";
                            echo"<tr><td class='fw-bolder'>Total:</td><td></td><td class='fw-bolder'>".$orders->total."</td></tr>";
                        ?>
                    </tbody>
                </table>
            </body>
            </html>

<?php
            

        }

        //print_r($orders);
    }
    
?>