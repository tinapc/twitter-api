<?php

require 'restclient.php';
require "configs.php";

$api = new RestClient(array(
    'base_url' => "api.buzzsumo.com", 
    'format' => "json", 
     // https://dev.twitter.com/docs/auth/application-only-auth
    // 'headers' => array('Authorization' => 'Bearer '.OAUTH_BEARER), 
));

$keyword = '';
if (isset($_POST['search_keyword']) && $_POST['search_keyword'] !== '')
{
	$keyword = $_POST['search_keyword'];
}

if (isset($_POST['page'])) {
	$page = $_POST['page'] - 1;
	$params = array('api_key' => 'd62f7989dfcdfba7a5a9ag8df7784ec1', 'q' => '#' . $keyword, 'page' => $page);	
} else {
	$params = array('api_key' => 'd62f7989dfcdfba7a5a9ag8df7784ec1', 'q' => '#' . $keyword);	
}


$result = $api->get("/search/influencers", $params);
// GET http://api.twitter.com/1.1/search/tweets.json?q=%23php
if($result->info->http_code == 200)
	$results = $result->decode_response();
	if(count($results->results)) {
		// echo "<pre>";
	    //print_r(objectToArray($results->results));
	    //echo "</pre>";
		$lists = objectToArray($results->results);
		$i = 0;
		foreach ($lists as $user) { ?>
			<tr>
				<td>
					<input type="checkbox">
					<input type="hidden" id="total_page_<?=$i?>" value="<?=$results->total_pages?>">
				</td>
				<td><img src="<?php echo $user['image']?>"/></td>
				<td><?php echo $user['name']?></td>
				<td><?php echo $user['bio']?></td>
				<td></td>
				<td><?php echo formatNumber($user['num_following'], 0)?></td>
				<td><?php echo formatNumber($user['num_followers'], 0)?></td>
				<td><?php echo $user['page_authority'] ?></td>
				<td><?php echo $user['domain_authority']?></td>
			</tr>
		<?php $i++; }

	} else {
		print_r($result->decode_response());
	}
