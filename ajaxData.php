<?php
ini_set('memory_limit','16M');
require "vendor/autoload.php";
require "configs.php";
use Abraham\TwitterOAuth\TwitterOAuth;

$friends = [];

if (isset($_POST['keyword_search']) && $_POST['keyword_search'] !== '')
{
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);

	if (isset($_POST['cursor']) && $_POST['cursor'] !== '') {
		$friends = $connection->get('friends/list', [
			'screen_name' => $_POST['keyword_search'], 
			'skip_status' => true, 
			'include_user_entities' => false, 
			'cursor' => $_POST['cursor'],
			'count' => 200
		]);
	
	} else {
		$friends = $connection->get('friends/list', [
			'screen_name' => $_POST['keyword_search'], 
			'skip_status' => true, 
			'include_user_entities' => false, 
			'cursor' => -1, 'count' => 200]
		);
	}

	if (count($friends) > 0) { 
		$i = 0;
		foreach ($friends->users as $user) { ?>
			<tr>
				<td>
					<input type="checkbox">
					<input type="hidden" id="next_cursor_<?= $i ?>" value="<?= $friends->next_cursor ?>">
					<input type="hidden" id="previous_cursor_<?= $i ?>" value="<?= $friends->previous_cursor ?>">
				</td>
				<td><img src="<?php echo $user->profile_image_url?>"/></td>
				<td><?php echo $user->name?></td>
				<td><?php echo $user->description?></td>
				<td><?php echo formatNumber($user->statuses_count,0)?></td>
				<td><?php echo formatNumber($user->friends_count, 0)?></td>
				<td><?php echo formatNumber($user->followers_count, 0)?></td>
				<td></td>
				<td><?php echo ceil(getSocialAuthority($user->screen_name)) ?></td>
			</tr>
		<?php $i++; }
	}
}