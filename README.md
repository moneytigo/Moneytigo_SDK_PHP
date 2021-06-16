MoneyTigo is a payment solution powered by the Fintech IPS INTERNATIONAL available at :  [https://www.moneytigo.com/].
This library is a PHP Client for the Moneytigo API. It allows you to initiate a payment via Moneytigo credit card solution.

Send an email to developer@moneytigo.com to get the full API documentation

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

$StartPayment = new Moneytigo\Payment([
'MerchantKey' => '<your-merchant-key>',
'SecretKey' => '<your-secret-key>',
'API' => 'https://payment.moneytigo.com'
]);

$data = [
	'amount' => '10',
	'RefOrder' => '123',
	'Customer_Email' => 'teste45678456@gmail.com'
];

$reponse = $StartPayment->startProcess($data); //this for retriewe authorization token 

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

Optional :
You can verify the status of the payment to see if the payment is done.

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

$StartPayment = new Moneytigo\Payment([
'MerchantKey' => '<your-merchant-key>',
'SecretKey' => '<your-secret-key>',
'API' => 'https://payment.moneytigo.com'
]);

$data = [
	'MerchantOrderId' => 'teste123456123'
];

$reponse = $StartPayment->getStatus($data); 

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
