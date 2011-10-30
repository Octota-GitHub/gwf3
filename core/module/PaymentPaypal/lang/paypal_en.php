<?php
$lang = array(

	'cfgg_info' => '<b>Remove .sandbox from two urls for production settings.</b><br/>Or use sandbox settings:<br/>API ENDPOINT: https://api-3t.sandbox.paypal.com/nvp<br/>URL: https://www.sandbox.paypal.com/webscr&cmd=_express-checkout&token= ',
	'cfg_fee_buy' => 'Fee in %% for purchases',	
	'cfg_fee_sell' => 'Fee in %% for sales',	
	'tt_cfg_PAYPAL_USE_PROXY' => 'Set this variable to TRUE to route all the API requests through proxy.',	
	'tt_cfg_PAYPAL_PROXY_PORT' => 'Proxy Port in case a proxy is used.',	
	'tt_cfg_PAYPAL_VERSION' => 'Version: this is the API version in the request. It is a mandatory parameter for each API request. The only supported value at this time is 2.3',
	'tt_cfg_PAYPAL_API_ENDPOINT' => 'This is the server URL which you have to connect for submitting your API request.',	
	'tt_cfg_PAYPAL_API_PASSWORD' => 'The password associated with the API user. If you are using your own API username, enter the API password that was generated by PayPal.',	
	'tt_cfg_PAYPAL_API_SIGNATURE' => 'The Signature associated with the API user. which is generated by paypal.',	
	'tt_cfg_PAYPAL_API_USERNAME' => 'The user that is identified as making the call. you can also use your own API username that you created on PayPal’s sandbox or the PayPal live site.',	
	'tt_cfg_PAYPAL_PROXY_HOST' => 'Proxy Host IP in case a proxy is used.',	
	'tt_cfg_PAYPAL_URL' => 'Define the PayPal URL. This is the URL that the buyer is first sent to to authorize payment with their paypal account change the URL depending if you are testing on the sandbox or going to the live PayPal site',
	'cfg_PAYPAL_USE_PROXY' => 'USE_PROXY',
	'cfg_PAYPAL_PROXY_PORT' => 'PROXY_PORT',	
	'cfg_PAYPAL_VERSION' => 'PAYPAL_VERSION',
	'cfg_PAYPAL_API_ENDPOINT' => 'API_ENDPOINT',	
	'cfg_PAYPAL_API_PASSWORD' => 'API_PASSWORD',	
	'cfg_PAYPAL_API_SIGNATURE' => 'API_SIGNATURE',	
	'cfg_PAYPAL_API_USERNAME' => 'API_USERNAME',	
	'cfg_PAYPAL_PROXY_HOST' => 'PROXY_HOST',	
	'cfg_PAYPAL_URL' => 'PAYPAL_URL',

	'paymodule_info2' => 'Thank you for choosing PayPal. Click the PayPal button again to get redirected to PayPal. Then come back and confirm the transaction.',
	'paymodule_info3' => 'Please double check your order again. Then push the PayPal button a third and last time to initiate the transaction.',
);
?>