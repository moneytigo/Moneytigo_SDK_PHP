MoneyTigo is a payment solution powered by the Fintech IPS INTERNATIONAL available at :  [https://www.moneytigo.com/].
This library is a PHP Client for the Moneytigo API. It allows you to initiate a payment via Moneytigo credit card solution.

Installation
============

Official installation method is via composer and its packagist package [moneytigo/payment](https://packagist.org/packages/moneytigo/payment).

```
$ composer require moneytigo/payment
```

Usage
=====

The simplest usage of the library would be as follow:

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

$Moneytigo = new Moneytigo\Payment([
'MerchantKey' => '<your-merchant-key>',
'SecretKey' => '<your-secret-key>',
'API' => 'https://payment.moneytigo.com'
]);

$data = [
	'amount' => '<amount-transaction>',
	'RefOrder' => '<your-reference-order-id>',
	'Customer_Email' => '<customer-email>
];

$reponse = $Moneytigo->initializePayment($data); 

if($reponse['http'] === 201)
{
 //Either you redirect the customer to the WEB payment url
 header('Location: ' . $reponse['DirectLinkIs']);
 //Or you just get the token to initiate one of our JS SDK libraries
 //@token is $reponse['SACS']
}
else
{
  //Error and display result
	echo "Http CODE : ".$reponse['http']."<br>";
	echo "MoneyTigo CODE : ".$reponse['Error_Code']."<br>";
	echo "Short error description :".$reponse['Short_Description']."<br>";
	echo "Long error description : ".$reponse['Full_Description'];
	
}
```
To set up another type of payment, like a recurring payment, in several times or other see the api documentation to know which parameter can be inserted in $data[].

Optional :
You can verify the status of the payment to see if the payment is done.

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

$Moneytigo = new Moneytigo\Payment([
'MerchantKey' => '<your-merchant-key>',
'SecretKey' => '<your-secret-key>',
'API' => 'https://payment.moneytigo.com'
]);

$data = [
	'MerchantOrderId' => '<your-reference-order-id>'
];

$reponse = $Moneytigo->getStatusPayment($data); 

if($reponse['http'] === 201) {
	print_r($reponse); //Displays the result of the transaction
}
else
{
	//An error has occurred you can see the reason
	echo "MoneyTigo CODE : ".$reponse['ErrorCode']."<br>";
	echo "Short error description :".$reponse['ErrorDescription']."<br>";
}
```

Instant payment notification (IPN)
==================================

If you want you can dynamically configure a URL that MoneyTigo will call automatically at the end of the payment to notify your server of the result of the transaction.

All you have to do is add a parameter when initiating the payment.

With the above example the payment parameters were :
```
$data = [
	'amount' => '<amount-transaction>',
	'RefOrder' => '<your-reference-order-id>',
	'Customer_Email' => '<customer-email>
];
```

By adding the notification url it would become : 
```
$data = [
	'amount' => '<amount-transaction>',
	'RefOrder' => '<your-reference-order-id>',
	'Customer_Email' => '<customer-email>,
	'urlIPN' => '<votre-url-de-notification>'
];
```
