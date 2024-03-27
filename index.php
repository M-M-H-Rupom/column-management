<?php
/**
 * Plugin Name: Column demo 
 * Author: Rupom
 * Description: plugin description
 * Version: 1.0
 *
 */
function clm_manage_column($columns){
    unset($columns['comments']);
    $columns['id'] = 'Post Id';
    $columns['thumbnail'] = 'Thumbnail';
    return $columns;
}
 add_filter( 'manage_pages_columns', 'clm_manage_column');
 function clm_custom_column($column,$post_id){
    if('id' == $column){
        echo $post_id;
    }elseif('thumbnail' == $column){
        $thumbnail = get_the_post_thumbnail($post_id, array(100,50));
        echo $thumbnail;
    }
 }
 add_action( 'manage_pages_custom_column', 'clm_custom_column',10,2);
?>