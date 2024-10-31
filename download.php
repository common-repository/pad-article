<?php
include('../../../wp-config.php');
global $wpdb;
$id = (int)$_GET['soft_id'];
$referer = $_SERVER['HTTP_REFERER'];
$needed_url = get_permalink($id);
if($referer != $needed_url){
header("Status: 301 Moved Permanently", false, 301);
header("Location: $needed_url");
exit();
}
$count = get_post_meta($id,'PAD_a_download_count',true);
$new_count = $count+1;
update_post_meta($id,'PAD_a_download_count',$new_count);
header('location:'.get_post_meta($id,'PAD_a_d_url',true).'');
?>