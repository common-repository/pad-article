<div class="wrap">  
<?php 
    if($_POST['pad_hidden'] == 'Y') {  
        //Form data sent  
        $auto_accept = $_POST['pad_auto_acc'];  
        update_option('PAD_a_auto_acc', $auto_accept);  
        $auto_update_data = $_POST['pad_auto_update_data'];  
        update_option('PAD_a_auto_update_data', $auto_update_data);  
        $auto_update_desc = $_POST['pad_auto_update_desc'];  
        update_option('PAD_a_auto_update_desc', $auto_update_desc);
		$regnow_ai = $_POST['regnow_ai'];  
        update_option('regnow_affiliate_id', $regnow_ai);
    
        ?>  
        <div class="updated"><p><strong><?php _e('Options saved.' ); ?></strong></p></div>  
        <?php  
    } else {  
        //Normal page display  
        $auto_a = get_option('PAD_a_auto_acc');  
        $aud = get_option('PAD_a_auto_update_data');  
        $audesc = get_option('PAD_a_auto_update_desc');     
		$rai = get_option('regnow_affiliate_id');
    } 
	if($_POST['add_article']) {  
	global $wpdb;
	$if_exist = $wpdb->get_row("SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'PAD_a_url' AND meta_value= '$_POST[pad_url]'");
	if(!$if_exist){
        //Form data sent 
			if(get_option('PAD_a_auto_acc') == 1){
			$statu = 'publish';
			} else {
			$statu = 'pending';
			}
		$cat_array = array();
		$cat_array = explode(',',PAD_article_category_parents($_POST['cat']));
		$post = array(
  'post_content'   => $_POST['long_desc'],
  'post_excerpt'   => $_POST['short_desc'],
  'post_status'    => $statu,
  'post_title'     => $_POST['name'],
  'post_type'      => 'post', //You may want to insert a regular post, page, link, a menu item or some custom post type
  'tags_input'     => $_POST['keyword'],
'post_category' => $cat_array
);
$post_id = wp_insert_post($post);
        $pad_url = $_POST['pad_url'];  
        update_post_meta($post_id,'PAD_a_url', $pad_url); 
		$p_vers = $_POST['version'];  
        update_post_meta($post_id,'PAD_a_s_version', $p_vers); 	
        $release_date = $_POST['r_d'].'-'.$_POST['r_m'].'-'.$_POST['r_a'];  
        update_post_meta($post_id,'PAD_a_release_date', $release_date);  
        $screenshot_url = $_POST['screen'];  
        update_post_meta($post_id,'PAD_a_screenshot', $screenshot_url);  
        $down_url = $_POST['d_url'];  
        update_post_meta($post_id,'PAD_a_d_url', $down_url);  
        $order_url = $_POST['o_url'];  
        update_post_meta($post_id,'PAD_a_o_url', $order_url); 
		$editor = $_POST['editor'];  
        update_post_meta($post_id,'PAD_a_editor', $editor);  
        $editor_url = $_POST['editor_url'];  
        update_post_meta($post_id,'PAD_a_editor_url', $editor_url);
		$licence = $_POST['licence'];  
        update_post_meta($post_id,'PAD_a_licence', $licence); 
		$OS = $_POST['os'];  
        update_post_meta($post_id,'PAD_a_os', $OS);  
        $language = $_POST['lang'];  
        update_post_meta($post_id,'PAD_a_lang', $language);	
		$price = $_POST['price'];  
        update_post_meta($post_id,'PAD_a_price', $price);
		$regnow = $_POST['regnow'];  
        update_post_meta($post_id,'PAD_a_regnow_p_id', $regnow);
		update_post_meta($post_id,'PAD_a_is_software',1);
		update_post_meta($post_id,'PAD_a_download_count',0);
        ?>  
        <div class="updated"><p><strong><?php _e('article added','pad_article'); ?></strong></p></div>  
        <?php  
		} else {
		?>
		<div class="updated"><p><strong><?php _e('This sofware already exist','pad_article'); ?></strong></p></div> 
		<?php
		}
    } else {    
    } 	
?> 
<div style="float:left">
    <h2><?php echo $lang['plugin_option']; ?></h2> 
    <form name="pad_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">  
        <input type="hidden" name="pad_hidden" value="Y">  
		<p><?php _e('auto publish sofwtare','pad_article'); ?> : <input type="radio" name="pad_auto_acc" value="1" <?php if($auto_a == 1) echo 'checked="checked"'; ?>><?php echo $lang['yes']; ?> <input type="radio" name="pad_auto_acc" value="0" <?php if($auto_a == 0) echo 'checked="checked"'; ?>><?php echo $lang['no']; ?></p>
        <p><?php _e('auto update software data','pad_article'); ?> : <input type="radio" name="pad_auto_update_data" value="1" <?php if($aud == 1) echo 'checked="checked"'; ?>><?php echo $lang['yes']; ?> <input type="radio" name="pad_auto_update_data" value="0" <?php if($aud == 0) echo 'checked="checked"'; ?>><?php echo $lang['no']; ?></p>
		<p><?php _e('auto update description and short description','pad_article'); ?> : <input type="radio" name="pad_auto_update_desc" value="1" <?php if($audesc == 1) echo 'checked="checked"'; ?>><?php echo $lang['yes']; ?> <input type="radio" name="pad_auto_update_desc" value="0" <?php if($audesc == 0) echo 'checked="checked"'; ?>><?php echo $lang['no']; ?></p>
	    <p><?php _e('Regnow affiliate ID','pad_article'); ?> : <input type="text" name="regnow_ai" value="<?php echo $rai; ?>"></p>
	  <p class="submit">  
        <input type="submit" name="Submit" value="<?php _e('update optionz','pad_article'); ?>" />  
        </p>  
    </form>
	<p><?php _e('If you choose to auto update software, we recommend you to use a cache plugin','pad_article'); ?></p>
</div>
<div style="float:left;margin-left:10px">
	<h2><?php _e('how_to','pad_article'); ?></h2>
	<?php _e('to show the template sofwtare, open you single.php file and replace','pad_article'); ?> :
	<pre><code>&lt;?php the_content(); ?&gt;</code></pre><br />
	<?php _e('by','pad_article'); ?>
	<pre><code>&lt;?php if(get_post_meta($id,'PAD_a_is_software',true) && get_post_meta($id,'PAD_a_is_software',true) == 1){ ?&gt;
	&lt;?php echo PAD_a_post_template($id); ?&gt;
	&lt;?php } else { ?&gt;
		&lt;?php the_content(); ?&gt;
	&lt;?php } ?&gt;</code></pre>
	<p><?php _e('Want to have a complete software repository portal, try <a href="http://www.allsoft.fr/plugin/pad-article-plus/" target="_blank">PAD article Plus</a>, a plugin + a themes for wordpress','pad_article'); ?>
</div>
<div style="clear:both"></div>
	<h2><?php _e('create article','pad_article'); ?></h2>
	<a href="http://pad.asp-software.org/repository/user/search.php?Home=user" target="_blank"><?php _e('find a pad file','pad_article');?></a>
	<?php
                     
// Includes
include_once("include/padfile.php");


// Read input
$URL = @$_POST["URL"];
if ( $URL == "" ) $URL = "http://";

// Create PAD file object
$PAD = new PADFile($URL);

?>
<form method='POST' action='<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>#prefill'>
  <table>
    <tr>
      <td><?php _e('pad file url','pad_article'); ?>:</td>
      <td>
        <input type='text' name='URL' size='60' value='<?php echo $PAD->URL; ?>'>
        <input type='submit' value='<?php _e('prefill the form','pad_article'); ?>'><br>
        &nbsp;<br>
<?php

  // If the form above has been posted, load the PAD file from the entered URL
  if ( $URL != "http://" )
  {
    echo "Loading <i>" . $PAD->URL . "</i> ... ";
    $PAD->Load();
    switch ( $PAD->LastError )
    {
      case ERR_NO_ERROR:
        echo "<font color='green'>OK</font>\n";
        break;
      case ERR_NO_URL_SPECIFIED:
        echo "<br><font color='red'>No URL specified.</font>";
        break;
      case ERR_READ_FROM_URL_FAILED:
        echo "<br><font color='red'>Cannot open URL.";
        if ($PADFile->LastErrorMsg != "")
          echo " (" . $PADFile->LastErrorMsg . ")";
        echo "</font>";
        break;
      case ERR_PARSE_ERROR:
        echo "<br><font color='red'>Parse Error: " . $PAD->ParseError . "</font>";
        break;
    }
  }
?>
      </td>
    </tr>
	<form method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
	<input type="hidden" name="pad_url" value="<?php echo $PAD->URL; ?>">
	<tr>
		<td><?php _e('category','pad_article'); ?></td>
		<td><?php wp_dropdown_categories('order_by=name&hide_empty=0&hierarchical=1'); ?></td>
	</tr>
    <tr>
      <td><?php _e('software name','pad_article'); ?>:</td>
      <td><input name='name' type='text' size='60'
                 value='<?php echo $PAD->XML->GetValue("XML_DIZ_INFO/Program_Info/Program_Name"); ?>'></td>
    </tr>
    <tr>
      <td><?php _e('Version','pad_article'); ?>:</td>
      <td><input name='version' type='text' size='60'
                 value='<?php echo $PAD->XML->GetValue("XML_DIZ_INFO/Program_Info/Program_Version"); ?>'></td>
    </tr>
	<tr>
      <td><?php _e('Short description','pad_article'); ?>:</td>
      <td><textarea name='short_desc' cols='42'><?php echo $PAD->GetBestDescription(250, "English"); ?></textarea></td>
    </tr>
    <tr>
      <td><?php _e('Long description','pad_article'); ?>:</td>
      <td><?php the_editor($PAD->GetBestDescription(2000, "English"),'long_desc'); ?></textarea></td>
    </tr>
	<tr>
      <td><?php _e('Keywords','pad_article'); ?>:</td>
      <td><input name='keyword' type='text' size='60'
                 value='<?php echo $PAD->XML->GetValue("XML_DIZ_INFO/Program_Descriptions/English/Keywords"); ?>'></td>
    </tr>
	<tr>
      <td><?php _e('Licence','pad_article'); ?>:</td>
      <td><input name='licence' type='text' size='60'
                 value='<?php echo $PAD->XML->GetValue("XML_DIZ_INFO/Program_Info/Program_Type"); ?>'></td>
    </tr>
	<tr>
      <td><?php _e('Price','pad_article'); ?>:</td>
      <td><input name='price' type='text' size='60'
                 value='<?php echo $PAD->XML->GetValue("XML_DIZ_INFO/Program_Info/Program_Cost_Dollars"); ?>'>$</td>
    </tr>
	<tr>
      <td><?php _e('OS supported','pad_article'); ?>:</td>
	  <?php
	  $os = $PAD->XML->GetValue("XML_DIZ_INFO/Program_Info/Program_OS_Support");
		$os = str_replace('Win7 x32,Win7 x64', 'Win 7',$os);
		$os = str_replace('Windows2000' ,'Win 2000',$os);
		$os = str_replace('Windows2003' ,'Win 2003',$os);
		$os = str_replace('Windows95' ,'Win 95',$os);
		$os = str_replace('Win95' ,'Win 95',$os);
		$os = str_replace('Windows98' ,'Win 98',$os);
		$os = str_replace('Win98' ,'Win 98',$os);
		$os = str_replace('Windows Vista Starter,Windows Vista Home Basic,Windows Vista Home Premium,Windows Vista Business,Windows Vista Enterprise,Windows Vista Ultimate,Windows Vista Home Basic x64,Windows Vista Home Premium x64,Windows Vista Business x64,Windows Vista Enterprise x64,Windows Vista Ultimate x64', 'Win vista',$os);
		$os = str_replace('Windows Vista Business,Windows Vista Enterprise,Windows Vista Ultimate','Win Vista',$os);
		$os = str_replace('WinVista,WinVista x64', 'Win Vista',$os);
		$os_supp = str_replace(',',', ',$os);
		?>
      <td><input name='os' type='text' size='60'
                 value='<?php echo $os; ?>'></td>
    </tr>
	<tr>
      <td><?php _e('Languages supported','pad_article'); ?>:</td>
      <td><input name='lang' type='text' size='60'
                 value='<?php echo str_replace(',',', ',$PAD->XML->GetValue("XML_DIZ_INFO/Program_Info/Program_Language")); ?>'></td>
    </tr>
	<tr>
      <td><?php _e('Screenshot','pad_article'); ?>:</td>
      <td><input name='screen' type='text' size='60'
                 value='<?php echo $PAD->XML->GetValue("XML_DIZ_INFO/Web_Info/Application_URLs/Application_Screenshot_URL"); ?>'></td>
    </tr>
	<tr>
      <td><?php _e('Order link','pad_article'); ?>:</td>
      <td><input name='o_url' type='text' size='60'
                 value='<?php echo $PAD->XML->GetValue("XML_DIZ_INFO/Web_Info/Application_URLs/Application_Order_URL"); ?>'></td>
    </tr>
	<tr>
      <td><?php _e('Regnow Product ID','pad_article'); ?>:</td>
      <td><input name='regnow' type='text' size='60'
                 value='<?php echo $PAD->XML->GetValue("XML_DIZ_INFO/Affiliates/Affiliates_Regnow_Product_ID"); ?>'></td>
    </tr>
	<tr>
      <td><?php _e('download link','pad_article'); ?>:</td>
      <td><input name='d_url' type='text' size='60'
                 value='<?php echo $PAD->XML->GetValue("XML_DIZ_INFO/Web_Info/Download_URLs/Primary_Download_URL"); ?>'></td>
    </tr>
	<tr>
      <td><?php _e('Release date','pad_article'); ?> (d/m/Y):</td>
		<td><input name='r_d' type='text' size='2' value='<?php echo $PAD->XML->GetValue("XML_DIZ_INFO/Program_Info/Program_Release_Day"); ?>'>/
			<input name='r_m' type='text' size='2' value='<?php echo $PAD->XML->GetValue("XML_DIZ_INFO/Program_Info/Program_Release_Month"); ?>'>/
			<input name='r_a' type='text' size='4' value='<?php echo $PAD->XML->GetValue("XML_DIZ_INFO/Program_Info/Program_Release_Year"); ?>'>
		</td>
    </tr>
	<tr>
      <td><?php _e('Editor','editor'); ?>:</td>
      <td><input name='editor' type='text' size='60'
                 value='<?php echo $PAD->XML->GetValue("XML_DIZ_INFO/Company_Info/Company_Name"); ?>'></td>
    </tr>
	<tr>
      <td><?php _e('Website url','pad_article'); ?>:</td>
      <td><input name='editor_url' type='text' size='60'
                 value='<?php echo $PAD->XML->GetValue("XML_DIZ_INFO/Company_Info/Company_WebSite_URL"); ?>'></td>
    </tr>
	<tr>
		<td></td>
		<td><input type="submit" name="add_article" value="<?php _e('Create article','pad_article'); ?>"></td>
	</tr>
	</table>
  </form>
</form>
</div>
