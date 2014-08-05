<?php

if (!defined('ABSPATH')) exit; // just in case


function kpg_open_in_new_window_control_2()  {

	if(!current_user_can('manage_options')) {
		die('Access Denied');
	}

	$options=kpg_oinw_get_options();
	extract($options);
// check for update submit
	if (array_key_exists('kpg_oinw_update',$_POST)) {
		$nonce=$_POST['kpg_oinw_update'];
		if (wp_verify_nonce($nonce,'kpg_oinw_update')) {
			if (array_key_exists('checktypes',$_POST)) {
				$checktypes='true';
			} else {
				$checktypes='false';
			}
			$options['checktypes']=$checktypes;
			update_option('kpg_open_in_new_window_options',$options);
			echo "<h2>Option Updated</h2>";
		}
	}
	
	$nonce=wp_create_nonce('kpg_oinw_update');
	
?>
<div class="wrap">
<h2>Open in new window Plugin</h2>
<div style="position:relative;float:right;width:35%;background-color:ivory;border:#333333 medium groove;padding:4px;margin-left:4px;">
    <p>This plugin is free and I expect nothing in return. If you would like to support my programming, you can buy my book of short stories.</p>
    <p>Some plugin authors ask for a donation. I ask you to spend a very small amount for something that you will enjoy. eBook versions for the Kindle and other book readers start at 99&cent;. The book is much better than you might think, and it has some very good science fiction writers saying some very nice things. <br/>
      <a target="_blank" href="http://www.blogseye.com/buy-the-book/">Error Message Eyes: A Programmer's Guide to the Digital Soul</a></p>
    <p>A link on your blog to one of my personal sites would also be appreciated.</p>
    <p><a target="_blank" href="http://www.WestNyackHoney.com">West Nyack Honey</a> (I keep bees and sell the honey)<br />
      <a target="_blank" href="http://www.cthreepo.com/blog">Wandering Blog</a> (My personal Blog) <br />
      <a target="_blank" href="http://www.cthreepo.com">Resources for Science Fiction</a> (Writing Science Fiction) <br />
      <a target="_blank" href="http://www.jt30.com">The JT30 Page</a> (Amplified Blues Harmonica) <br />
      <a target="_blank" href="http://www.harpamps.com">Harp Amps</a> (Vacuum Tube Amplifiers for Blues) <br />
      <a target="_blank" href="http://www.blogseye.com">Blog&apos;s Eye</a> (PHP coding) <br />
      <a target="_blank" href="http://www.cthreepo.com/bees">Bee Progress Beekeeping Blog</a> (My adventures as a new beekeeper) </p>
  </div>
<p>This plugin installs some javascript in the footer of every page. When your page finishes loading, the javascript steps through the links on the page looking for links that lead to other domains. It alters these links so that they will open in a new window.</p>
<p>The javascript does not look in any embedded iframes, so it will not work with some ads and affiliate links. It will also not work where other javascript is executed through an onclick event or the link begins with 'javascript:'</p>

<p>Since the javascript does not run until the web page is completely loaded, links on a page that is slow to load will not open in a new window until the page is fully loaded.</p>
  <hr/>

  <form method="post" action="">
    <input type="hidden" name="action" value="update" />
    <input type="hidden" name="kpg_oinw_update" value="<?php echo $nonce;?>" />
	Open file types such as PDF, MP3, images, archives and video in a new window: 
	<input name="checktypes" type="checkbox" value="true" <?php if ($checktypes=='true') {?> checked="checked" <?php } ?>/>
    <br/>
    <p class="submit">
      <input class="button-primary" value="Save Changes" type="submit">
    </p>
  <form>

</div>

<?php
}
