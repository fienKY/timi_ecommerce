<?php
$name = $_POST['name'] ?? null;
$email = $_POST['email'] ?? null;
$phone = $_POST['phone'] ?? null;
$total = $_POST['total'] ?? null;
$orderId = $_POST['orderId'] ?? null;

// Validate fields
if (!$name || !$email || !$phone || !$total || !$orderId) {
  http_response_code(400);
  echo json_encode(["status" => "error", "msg" => "Missing required fields"]);
  exit;
}

// Convert amount to integer (sen)
$amountInSen = intval($total); // pastikan RM50.00 = 5000

$data = array(
  'userSecretKey'           => '4gbco9oj-lek0-jpy3-zhre-tparooavxo2r',
  'categoryCode'            => 'sfsh98vz',
  'billName'                => 'TIMI products',
  'billDescription'         => 'payment for timi products',
  'billPriceSetting'        => 1,
  'billPayorInfo'           => 1,
  'billAmount'              => $amountInSen,
  'billReturnUrl'           => 'https://timi-ecommerce-r1b3.onrender.com/receipt.html?orderId=' . urlencode($orderId),
  'billCallbackUrl'         => 'https://timi-ecommerce-r1b3.onrender.com/callback',
  'billExternalReferenceNo' => $orderId,
  'billTo'                  => $name,
  'billEmail'               => $email,
  'billPhone'               => $phone,
  'billSplitPayment'        => 0,
  'billDisplayMerchant'     => 1
);

// Send cURL request
$ch = curl_init();
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_URL, 'https://toyyibpay.com/index.php/api/createBill');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
$response = curl_exec($ch);

if ($response === false) {
  $error = curl_error($ch);
  curl_close($ch);
  http_response_code(500);
  echo json_encode(["status" => "error", "msg" => "Curl error: $error"]);
  exit;
}

curl_close($ch);

// Debug log (can be viewed in Render logs)
error_log("ToyyibPay response: " . $response);

// Return response to frontend
header('Content-Type: application/json');
echo $response;