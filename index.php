<?php
/*
Plugin Name: PAD article
Plugin URI: http://www.allsoft.fr
Description: Autmatically create post about software from PAD file
Version: 1.02
Author: Hilflo
Author URI: http://www.allsoft.fr/
*/
function PAD_a_admin() { 
    include('pad_admin.php');  
}
 
function PAD_a_admin_actions() {  
    add_options_page("Software article", "Software article", 1, "Createarticle", "PAD_a_admin");  
}  
add_action('admin_menu', 'PAD_a_admin_actions'); 

add_action( 'wp_enqueue_scripts', 'PAD_a_stylesheet' );

function PAD_a_stylesheet() {
    wp_register_style( 'PAD_a', plugins_url('style.css', __FILE__) );
    wp_enqueue_style( 'PAD_a' );
}

function pad_article_textdomain() {
	load_plugin_textdomain('pad_article', 'wp-content/plugins/pad-article/languages');
}
add_action('init', 'pad_article_textdomain');


function create_widget_PAD_a()
{
	register_widget("class_widget_PAD_a");
}
add_action("widgets_init", "create_widget_PAD_a");

class class_widget_PAD_a extends WP_widget
{

	 function class_widget_PAD_a() {
                    $widget_ops = array(
                    'classname' => 'class_widget_PAD_a',
                    'description' => 'Top downloaded sofwtare from pad_article plugin'
          );

          $this->WP_Widget(
                    'class_widget_PAD_a',
                    'Top download',
                    $widget_ops
          );
}

	function widget($arguments, $data)
	{
		$defaut = array(
				"title" => "Top download",
				"count" => "5"
				);
	$data = wp_parse_args($data, $defaut);

	global $wpdb;
	$table_prefix = $wpdb->prefix;

	extract($arguments);

	echo $before_widget;
	echo $before_title . $data['title'] . $after_title;
	query_posts('meta_key=PAD_a_download_count&orderby=meta_value_num&order=DESC&posts_per_page='.$data['count']);
	echo '<ul>';
	while ( have_posts() ) : the_post();
	?>
	<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
	<?php 
endwhile;
	echo '</ul>';
	echo $after_widget;
	}

	function update($content_new, $content_old)
	{
	$content_new['title']  = esc_attr($content_new['title']);
	$content_new['count']  = esc_attr($content_new['count']);
	return $content_new;
	}

	function form($data)
	{
	$defaut = array(
				"title" => "Top Download",
				"count" => "5"
				);
	$data = wp_parse_args($data, $defaut);

	global $wpdb;
	$table_prefix = $wpdb->prefix;

	?>
	<p>
	<label for="<?php echo $this->get_field_id('title'); ?>">Widget title :</label><br />
	<input value="<?php echo $data['title']; ?>" name="<?php echo $this->get_field_name('title'); ?>" id="<?php echo $this->get_field_id('title'); ?>" type="text" />
	</p>
	<p>
	<label for="<?php echo $this->get_field_id('count'); ?>">Number of software :</label><br />
	<input value="<?php echo $data['count']; ?>" name="<?php echo $this->get_field_name('count'); ?>" id="<?php echo $this->get_field_id('count'); ?>" type="text" />
	</p>
	<?php
	}

}
function PAD_a_post_template($id){
if(get_option('pad_a_auto_update_data') == 1)
{
if(get_post_meta($id,'PAD_a_url',true))
	{
include_once("./wp-content/plugins/pad-article/include/padfile.php");	
	$PAD = new PADFile(get_post_meta($id,'PAD_a_url',true));
	$PAD->URL;
    $PAD->Load();
	$padversion = $PAD->XML->GetValue("XML_DIZ_INFO/Program_Info/Program_Version");
		if($padversion > get_post_meta($id,'PAD_a_s_version',true))
		{
		$version = $padversion;
		$longdesc = $PAD->GetBestDescription(2000, "English");
		$shortdesc = $PAD->XML->GetValue("XML_DIZ_INFO/Program_Descriptions/English/Char_Desc_250");
		$key = $PAD->XML->GetValue("XML_DIZ_INFO/Program_Descriptions/English/Keywords");
		$screen = $PAD->XML->GetValue("XML_DIZ_INFO/Web_Info/Application_URLs/Application_Screenshot_URL");
		$dlink = $PAD->XML->GetValue("XML_DIZ_INFO/Web_Info/Download_URLs/Primary_Download_URL");
		$blink = $PAD->XML->GetValue("XML_DIZ_INFO/Web_Info/Application_URLs/Application_Order_URL");
		$price = $PAD->XML->GetValue("XML_DIZ_INFO/Program_Info/Program_Cost_Dollars");
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
		$lang = $PAD->XML->GetValue("XML_DIZ_INFO/Program_Info/Program_Language");
		$release = $PAD->XML->GetValue("XML_DIZ_INFO/Program_Info/Program_Release_Day").'-'.$PAD->XML->GetValue("XML_DIZ_INFO/Program_Info/Program_Release_Month").'-'.$PAD->XML->GetValue("XML_DIZ_INFO/Program_Info/Program_Release_Year");
		$licence = $PAD->XML->GetValue("XML_DIZ_INFO/Program_Info/Program_Type");
		$regnow = $PAD->XML->GetValue("XML_DIZ_INFO/Affiliates/Affiliates_Regnow_Product_ID");
		$editor = $PAD->XML->GetValue("XML_DIZ_INFO/Company_Info/Company_Name");
		$editor_url = $PAD->XML->GetValue("XML_DIZ_INFO/Company_Info/Company_WebSite_URL");
		if(get_option('PAD_a_auto_update_desc') == 1){
		 $my_post = array();
		$my_post['ID'] = $id;
		$my_post['post_content'] = $longdesc;
		$my_post['post_excerpt'] = $shortdesc;
		$my_post['post_date'] = date('Y-m-d H:i:s');
		$my_post['post_date_gmt'] = date('Y-m-d H:i:s');
		wp_update_post($my_post);  
        update_post_meta($id,'PAD_a_s_version', $version); 	 
        update_post_meta($id,'PAD_a_release_date', $release);    
        update_post_meta($id,'PAD_a_screenshot', $screen);   
        update_post_meta($id,'PAD_a_d_url', $dlink);   
        update_post_meta($id,'PAD_a_o_url', $blink);  
        update_post_meta($id,'PAD_a_licence', $licence); 
        update_post_meta($id,'PAD_a_os', $os_supp);  
        update_post_meta($id,'PAD_a_lang', $lang);	 
        update_post_meta($id,'PAD_a_price', $price);
		update_post_meta($id,'PAD_a_regnow_p_id',$regnow);
		update_post_meta($id,'PAD_a_editor_url',$editor_url);
		update_post_meta($id,'PAD_a_editor',$editor);
			}
			else
			{
		$my_post = array();
		$my_post['ID'] = $id;
		$my_post['post_date'] = date('Y-m-d H:i:s');
		$my_post['post_date_gmt'] = date('Y-m-d H:i:s');
		wp_update_post($my_post);
		update_post_meta($id,'PAD_a_s_version', $version); 	 
        update_post_meta($id,'PAD_a_release_date', $release);    
        update_post_meta($id,'PAD_a_screenshot', $screen);   
        update_post_meta($id,'PAD_a_d_url', $dlink);   
        update_post_meta($id,'PAD_a_o_url', $blink);  
        update_post_meta($id,'PAD_a_licence', $licence); 
        update_post_meta($id,'PAD_a_os', $os_supp);  
        update_post_meta($id,'PAD_a_lang', $lang);	 
        update_post_meta($id,'PAD_a_price', $price);
		update_post_meta($id,'PAD_a_regnow_p_id',$regnow);
		update_post_meta($id,'PAD_a_editor_url',$editor_url);
		update_post_meta($id,'PAD_a_editor',$editor);
			}
		}
	}
}
$data = get_post($id);
?>
<div id="pad_box" itemscope itemtype="http://schema.org/SoftwareApplication">
	<img itemprop="image" src="<?php echo get_post_meta($id,'PAD_a_screenshot',true); ?>" style="display:none">
	<img itemprop="image" src="<?php echo get_bloginfo('wpurl').'/wp-content/plugins/pad-article/img.php?src='.get_post_meta($id,'PAD_a_screenshot',true).'&w=200&q=95'; ?>"><span itemprop="name" style="display:none"><?php echo $data->post_title; ?></span><span itemprop="description"><?php echo $data->post_content; ?></span>
	<div class="clearboth"></div>
	<div id="pad_info_box">
		<h2><?php _e('more info','pad_article'); ?></h2>
		<span class="info_line"><?php _e('Version','pad_article') ?> : <strong><?php echo get_post_meta($id,'PAD_a_s_version',true); ?></strong></span>
		<span class="info_line"><?php _e('Release Date','pad_article'); ?> : <strong><time itemprop="datePublished" datetime="<?php echo date('Y-m-d',strtotime(get_post_meta($id,'PAD_a_release_date',true))); ?>"><?php echo get_post_meta($id,'PAD_a_release_date',true); ?></time></strong></span>
		<span class="info_line"><?php _e('OS supported','pad_article') ; ?> : <strong><span itemprop="operatingSystems"><?php echo get_post_meta($id,'PAD_a_os',true); ?></span></strong></span>
		<span class="info_line"><?php _e('Lang supported','pad_article'); ?> : <strong><?php echo get_post_meta($id,'PAD_a_lang',true); ?></strong></span>
		<span class="info_line"><?php _e('Licence','pad_article'); ?> : <strong><?php echo get_post_meta($id,'PAD_a_licence',true); ?></strong></span>
		<?php if(get_post_meta($id,'PAD_a_price',true) <> '' || get_post_meta($id,'PAD_a_price',true) <> 0) { ?>
		<span class="info_line" itemprop="offers" itemscope itemtype="http://schema.org/Offer" ><?php _e('Price','pad_article'); ?> : <strong><span itemprop="price">$<?php echo get_post_meta($id,'PAD_a_price',true); ?></span><meta itemprop="priceCurrency" content="USD" /><link itemprop="availability" href="http://schema.org/InStock" /><span style="display:none">INSTALL</span></strong></span>
		<?php } else { ?>
		<span class="info_line hidden" itemprop="offers" itemscope itemtype="http://schema.org/Offer" ><?php _e('Price','pad_article'); ?> : <strong><span itemprop="price">$0.00</span><meta itemprop="priceCurrency" content="USD" /><link itemprop="availability" href="http://schema.org/InStock" /><span style="display:none">INSTALL</span></strong></span>
		<?php } ?>
		<span class="info_line"><?php _e('Downloaded','pad_article'); ?> : <strong><meta itemprop="interactionCount" content="UserDownloads:<?php echo get_post_meta($id,'PAD_a_download_count',true); ?>"/><?php echo get_post_meta($id,'PAD_a_download_count',true); ?></strong></span>
		<span class="info_line" itemprop="author" itemscope itemtype="http://schema.org/Organization"><?php _e('editor','pad_article'); ?> : <strong><a href="<?php echo get_post_meta($id,'PAD_a_editor_url',true); ?>" target="_blank" itemprop="url"><span itemprop="name"><?php echo get_post_meta($id,'PAD_a_editor',true); ?></span></a></strong></span>
		<span class="info_line down_buy">
			<span class="download_pad"><a href="<?php echo get_bloginfo('wpurl'); ?>/wp-content/plugins/pad-article/download.php?soft_id=<?php echo $id; ?>"><?php _e('download','pad_article'); ?></a></span>
			<?php if(get_post_meta($id,'PAD_a_o_url',true) <> ''){ ?>
			<?php if(get_post_meta($id,'PAD_a_regnow_p_id',true) <> ''){ 
			$order_link = 'http://www.regnow.com/softsell/nph-softsell.cgi?item='.get_post_meta($id,'PAD_a_regnow_p_id',true).'&affiliate='.get_option('regnow_affiliae_id');
			} else {
			$order_link = get_post_meta($id,'PAD_a_o_url',true);
			}
			?>
			<span class="buy_pad"><a href="<?php echo $order_link; ?>" target="_blank"><?php _e('buy','pad_article'); ?></span>
			<?php } ?>
		</span>
	</div>
</div>
<?php
}

$postid = isset($_GET['post'])?$_GET['post']:'';

if($postid && get_post_meta($postid,'PAD_a_is_software',true) == 1){
add_action( 'add_meta_boxes', 'PAD_article_add_custom_box' );
}
add_action( 'save_post', 'PAD_article_save_postdata' );

function PAD_article_add_custom_box() {
    add_meta_box( 
        'PAD_article_sectionid',
        __( 'All other details', 'pad_article' ),
        'PAD_article_inner_custom_box',
        'post' 
    );
}

/* Prints the box content */
function PAD_article_inner_custom_box( $post ) {
  // Use nonce for verification
  wp_nonce_field( plugin_basename( __FILE__ ), 'pad_article_nonce' );

  // The actual fields for data entry
  echo '<label for="exerpt">';
       _e("Short description", 'pad_article_plus' );
  echo '</label> ';
  echo '<textarea id="excerpt" name="excerpt">'.$post->post_excerpt.'</textarea>';
  echo '<label for="version">'._e('Version','pad_article').'</label><br />';
  echo '<input type="text" name="version" id="version" value="'.get_post_meta($post->ID,'PAD_a_s_version',true).'" size="120"><br />';
  echo '<label for="os">'._e('os supported','pad_article').'</label><br />';
  echo '<input type="text" name="os" id="os" value="'.get_post_meta($post->ID,'PAD_a_os',true).'" size="120"><br />';
  echo '<label for="lang">'._e('Language supported','pad_article').'</label><br />';
  echo '<input type="text" name="lang" id="lang" value="'.get_post_meta($post->ID,'PAD_a_lang',true).'" size="120"><br />';
  echo '<label for="screen">'._e('Screenshot','pad_article').'</label><br />';
  echo '<input type="text" name="screen" id="screen" value="'.get_post_meta($post->ID,'PAD_a_screenshot',true).'" size="120"><br />';
  echo '<label for="download">'._e('Download url','pad_article').'</label><br />';
  echo '<input type="text" name="down" id="down" value="'.get_post_meta($post->ID,'PAD_a_d_url',true).'" size="120"><br />';
  echo '<label for="buy">'._e('Order url','pad_article').'</label><br />';
  echo '<input type="text" name="buy" id="buy" value="'.get_post_meta($post->ID,'PAD_a_o_url',true).'" size="120"><br />';
  echo '<label for="price">'._e('Price','pad_article').'</label><br />';
  echo '$<input type="text" name="price" id="price" value="'.get_post_meta($post->ID,'PAD_a_price',true).'" size="120"><br />';
  echo '<label for="licence">'._e('Licence','pad_article').'</label><br />';
  echo '<input type="text" name="licence" id="licence" value="'.get_post_meta($post->ID,'PAD_a_licence',true).'" size="120"><br />';
  echo '<label for="editor">'._e('Editor','pad_article').'</label><br />';
  echo '<input type="text" name="editor" id="editor" value="'.get_post_meta($post->ID,'PAD_a_editor',true).'" size="120"><br />';
  echo '<label for="e_url">'._e('Editor url','pad_article').'</label><br />';
  echo '<input type="text" name="e_url" id="e_url" value="'.get_post_meta($post->ID,'PAD_a_editor_url',true).'" size="120"><br />';
  echo '<label for="release">'._e('Release date','pad_article').'</label><br />';
  echo '<input type="text" name="r_date" id="r_date" value="'.get_post_meta($post->ID,'PAD_a_release_date',true).'" size="120"><br />';
}

/* When the post is saved, saves our custom data */
function PAD_article_save_postdata( $post_id ) {
  // verify if this is an auto save routine. 
  // If it is our form has not been submitted, so we dont want to do anything
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return;

  // verify this came from the our screen and with proper authorization,
  // because save_post can be triggered at other times

  if ( !wp_verify_nonce( $_POST['pad_article_nonce'], plugin_basename( __FILE__ ) ) )
      return;

  
  // Check permissions
  if ( 'page' == $_POST['post_type'] ) 
  {
    if ( !current_user_can( 'edit_page', $post_id ) )
        return;
  }
  else
  {
    if ( !current_user_can( 'edit_post', $post_id ) )
        return;
  }
 
	
	update_post_meta($post_id,'PAD_a_screenshot',$_POST['screen']);
	update_post_meta($post_id,'PAD_a_os',$_POST['os']);
	update_post_meta($post_id,'PAD_a_lang',str_replace(',',', ',$_POST['lang']));
	update_post_meta($post_id,'PAD_a_d_url',$_POST['down']);
	update_post_meta($post_id,'PAD_a_o_url',$_POST['buy']);
	update_post_meta($post_id,'PAD_a_price',$_POST['price']);
	update_post_meta($post_id,'PAD_a_licence',$_POST['licence']);
	update_post_meta($post_id,'PAD_a_release_date',$_POST['r_date']);
	update_post_meta($post_id,'PAD_a_editor',$_POST['editor']);
	update_post_meta($post_id,'PAD_a_editor_url',$_POST['e_url']);
	update_post_meta($post_id,'PAD_a_s_version',$_POST['version']);
}
function pad_article_cut_string($chaine,$max){
if(strlen($chaine)>=$max)
  {
  // Met la portion de chaine dans $chaine
  $chaine=substr($chaine,0,$max); 
  // position du dernier espace
  $espace=strrpos($chaine," "); 
  // test si il ya un espace
  if($espace)
  // si ya 1 espace, coupe de nouveau la chaine
  $chaine=substr($chaine,0,$espace);
  // Ajoute ... à la chaine
  $chaine .= '...';
  }
  return $chaine;
}

function PAD_article_category_parents($id, $link = false,$separator = ',',$nicename = false,$visited = array()) {
  $chain = '';$parent = &get_category($id);
    if (is_wp_error($parent))return $parent;
    if ($nicename)$name = $parent->name;
    else $name = $parent->cat_name;
    if ($parent->parent && ($parent->parent != $parent->term_id ) && !in_array($parent->parent, $visited)) {
        $visited[] = $parent->parent;$chain .= PAD_article_category_parents( $parent->parent, $link, $separator, $nicename, $visited );}
	$chain .= $parent->term_id  . $separator;
    return $chain;}