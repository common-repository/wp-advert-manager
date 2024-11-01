<?php
/*
Plugin Name: WP Advert Manager
Plugin URI: http://2lx.ru/2009/02/wp-advert-manager/
Description: Plugin, that controls your advertisement codes (such as <a href='http://google.com/adsense' target='_blank'>Google Adsense</a>, <a href='http://2lx.ru/2008/09/zorka-udobnyj-cop-beguna/' target='_blank'>Зорька (ru)</a>, counters/ratings, etc.) in begining and ending of posts.
Version: 0.8
Author: Le)(x
Author URI: http://2lx.ru
*/

$adman_settings = array(
	'start_ad'	=> '',
	'end_ad'	=> ''
);

add_option('adman_settings',$adman_settings,'AdMan advertisement codes');
$adman_settings = get_option('adman_settings');

add_filter('the_content','adman_add_post', 60);
add_action('admin_menu', 'adman_menu');


function adman_add_post($content) { // adding ads to post
	global $adman_settings;
	$content = $adman_settings['start_ad'] . $content . $adman_settings['end_ad'];
	return $content;
}

function adman_menu() { // creating new entry in Optons menu
	add_options_page('WP-AdMan Options', 'WP Advert Manager', 8, __FILE__, 'adman_options');
}

function adman_options() { // edit options window 
	global $adman_settings;

	if (isset($_POST['bsave'])) {
		$adman_settings['start_ad']	= $_POST['start_ad'];
		$adman_settings['end_ad']	= $_POST['end_ad'];

		update_option('adman_settings',$adman_settings);

		echo '<div id="message" class="updated fade"><p>Advert codes saved.</p></div>';
	}
?>

<div class="wrap">
<h2>WP Advert Manager</h2>
<form method="post" action="">

<table class="form-table">

<tr valign="top">
<th scope="row">Advert code at the begining of post</th>
<td><textarea name="start_ad" class="large-text" rows="3"><?php echo $adman_settings['start_ad']; ?></textarea></td>
</tr>
 
<tr valign="top">
<th scope="row">Advert code at the end of post</th>
<td><textarea name="end_ad" class="large-text" rows="3"><?php echo $adman_settings['end_ad']; ?></textarea></td>
</tr>
</table>

<p class="submit">
<input type="submit" name="bsave" class="button-primary" value="Save" />
</p>

</form>
</div>

<?php
}

?>