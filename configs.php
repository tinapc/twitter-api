<?php
ini_set('memory_limit','16M');
ini_set('max_execution_time', '600');

define('CONSUMER_KEY', 'goGveM7otiaOKPDlthU2DSxU0');
define('CONSUMER_SECRET', 'CToJGXwoKxFuwt6iw9zyJkF1jmJ7JkiOcZnUIbChmptNMWZjyt');
define('ACCESS_TOKEN', '185242205-iZemju676YLiwDOwkLiIUvQiRpRMEa0mAc1pvkyn');
define('ACCESS_TOKEN_SECRET', 'RqH1aVngZ4Pc3r2X7AQnnfLSdYFFcQbQRQvWQMo7Tkh5I');


//Convert an object to an array
function objectToArray ($object) {
    if(!is_object($object) && !is_array($object))
        return $object;

    return array_map('objectToArray', (array) $object);
}

// Retrieve social authority
function getSocialAuthority($screen_name) 
{
	$uri = 'https://api.followerwonk.com/social-authority';
	
	// Enter your Access ID and Secret Key from http://followerwonk.com/social-authority below
	$accessID = 'member-MDNiYmIwN2UtYzE2Mi01NWZhLTkwZTEtNTE5ZWI5ODdhMzE5';
	$secretKey = 'dgozikpvlotbunkxwyougxptvfwrtijl';
	$time = time() + 500;
	$signature = urlencode( base64_encode( hash_hmac( "sha1", "{$accessID}\n{$time}", $secretKey, true ) ) );
	$auth = "AccessID={$accessID};Timestamp={$time};Signature={$signature}";
	// Initialize an array of users. We call the API once for each of the usernames. There are more efficient alternatives.

	// Fetch the Json object and decode it into an array
	$response = json_decode( file_get_contents( "{$uri}?screen_name={$screen_name};{$auth}" ), true );
	
	$social_authority = $response['_embedded'][0]['social_authority'];
	
	return $social_authority;
}


//Formatting the number
function formatNumber($number, $cents = 1) { // cents: 0=never, 1=if needed, 2=always
	if (is_numeric($number)) { // a number
		if (!$number) { // zero
		  $num = ($cents == 2 ? '0.00' : '0'); // output zero
		} else { // value
		  if (floor($number) == $number) { // whole number
		    $num = number_format($number, ($cents == 2 ? 2 : 0)); // format
		  } else { // cents
		    $num = number_format(round($number, 2), ($cents == 0 ? 0 : 2)); // format
		  } // integer or decimal
		} // value
		return $num;
	} // numeric
} 