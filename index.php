<?php
$orderid = rand(1, 100);
$merchant = '*******************';
$password = '*************************';
$amount = '4500';
$returnUrl = 'https://*******************';
$currency = 'QAR';
$operation = 'PURCHASE';
$merchantname = '*******************';
$orderdesc = 'TEST';

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://mastercard.gateway.mastercard.com/api/nvp/version/75");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt(
    $ch,
    CURLOPT_POST, 1
);

curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    "apiOperation" => "INITIATE_CHECKOUT",
    "apiPassword" => $password,
    "apiUsername" => "merchant.$merchant",
    "merchant" => $merchant,
    "interaction.operation" => $operation,
    "interaction.returnUrl" => $returnUrl,
    "interaction.merchant.name" => $merchantname,
    "order.id" => $orderid,
    "order.amount" => $amount,
    "order.currency" => $currency,
    "order.description" => $orderdesc,
]));

$headers = array();
$headers[] = 'Content-Type: application/x-www-form-urlencoded';

curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'ERROR:' . curl_error($ch);
}

curl_close($ch);
//print_r(explode("=", explode("&", $result) [3])[1]);
//print_r($ch);

// $sessionid= explode("=", explode("&", $result)[3])[1];

//  print_r(explode("&", $result)[3]);

$sessionid = explode("=", explode("&", $result)[3])[1];

?>

<script src="https://mastercard.gateway.mastercard.com/static/checkout/checkout.min.js"
    data-cancel="https://*******************/">
</script>
 


<script type="text/javascript">
function errorCallback(error) {
    alert("Error: " + JSON.stringify(error));
    window.location.href = "http://*******************";
}

Checkout.configure({
    merchant: '<?php echo $merchant ?>',
    order: {
        amount: function() {
            return <?php echo $amount; ?>;
        },
        currency: '<?php echo $currency; ?>',
        description: 'Standard Plan 3 Months',
        id: <?php echo $orderid; ?>,
    },

    interaction: {
        marchent: {
            name: 'NASEER IQBAL',
            address: {
                line1: 'OK',
                line2: 'OK'
            }
        }
    },

    session: {
        id: '<?php echo $sessionid; ?>'
    }
});

Checkout.showPaymentPage();
</script>



<script src="https://mastercard.gateway.mastercard.com/static/checkout/checkout.min.js"></script>


<script>
// Configure Checkout first
Checkout.configure({
    session: {
        id: '<?php echo $sessionid; ?>'
    }
})
 
</script>
