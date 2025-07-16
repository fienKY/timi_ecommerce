<?php
$name = $_POST['name'] ?? null;
$email = $_POST['email'] ?? null;
$phone = $_POST['phone'] ?? null;
$total = $_POST['total'] ?? null;
$orderId = $_POST['orderId'] ?? null;

if (!$name || !$email || !$phone || !$total || !$orderId) {
  http_response_code(400);
  echo json_encode(["status" => "error", "msg" => "Missing required fields"]);
  exit;
}

$data = array(
  'userSecretKey'=> '4gbco9oj-lek0-jpy3-zhre-tparooavxo2r',
  'categoryCode'=> 'sfsh98vz',
  'billName'=> 'TIMI products',
  'billDescription'=> 'payment for timi products',
  'billPriceSetting'=> 1,
  'billPayorInfo'=> 1,
  'billAmount'=> $total,
  'billReturnUrl'=> 'http://localhost/receipt.html?orderId=' . urlencode($orderId),
  'billCallbackUrl'=> '',
  'billExternalReferenceNo'=> $orderId,
  'billTo'=> $name,
  'billEmail'=> $email,
  'billPhone'=> $phone,
  'billSplitPayment'=> 0,
  'billDisplayMerchant'=> 1
);

$ch = curl_init();
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_URL, 'https://toyyibpay.com/index.php/api/createBill' );
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
$response = curl_exec($ch);
curl_close($ch);

header('Content-Type: application/json');
echo $response;