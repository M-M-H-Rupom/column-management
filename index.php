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
    $columns['wordcount'] = 'wordcount';
    return $columns;
}
 add_filter( 'manage_pages_columns', 'clm_manage_column');
 function clm_custom_column($column,$post_id){
    if('id' == $column){
        echo $post_id;
    }elseif('thumbnail' == $column){
        $thumbnail = get_the_post_thumbnail($post_id, array(100,50));
        echo $thumbnail;
    }elseif('wordcount' == $column){
        $_post = get_post($post_id);
        $content = $_post->post_content;
        $word_n = str_word_count(strip_tags($content));
        echo $word_n;
    }
 }
 add_action( 'manage_pages_custom_column', 'clm_custom_column',10,2);
//  filter based on post id 
 function manage_filter(){
    if(isset($_GET['post_type'])  == 'page'){
        $filter = isset($_GET['demofilter']) ? $_GET['demofilter'] : '';
        $options =array(
            '0' => 'Select post',
            '1' => 'Some data 1',
            '2' => 'Some data 2',
        );
        ?>
        <select name="demofilter" id="">
        <?php
        foreach($options as $key => $option){
            $selected ='';
            if($key == $filter){
                $selected = 'selected';
            }
            printf("<option value='%s' %s> %s</option>",$key,$selected,$option);
        }
        ?>
        </select>
        <?php
    ?>
    <!-- <select name="demofilter" id="">
        <option value="0">Select Post</option>
        <option value="1">Some data 1</option>
        <option value="2">Some data 2</option>
    </select> -->
    <?php
    }
 }
 add_action( 'restrict_manage_posts', 'manage_filter');
 function filter_get_post($wpquery){
    if(!is_admin()){
        return;
    }
    $filter = isset($_GET['demofilter']) ? $_GET['demofilter'] : '';
    if('1'==$filter){
        $wpquery->set('post__in',array(42,25));
    }elseif('2' == $filter){
        $wpquery->set('post__in',array(76));
    }
 }
 add_action( 'pre_get_posts','filter_get_post');
 
// thumbnail filter 
 function manage_thumbnail_filter(){
    if(isset($_GET['post_type'])  == 'page'){
        $filter = isset($_GET['demothumbnail']) ? $_GET['demothumbnail'] : '';
        $options =array(
            '0' => 'Select Thumbnail',
            '1' => 'Has thumbnail',
            '2' => 'No thumbnail',
        );
        ?>
        <select name="demothumbnail" id="">
        <?php
        foreach($options as $key => $option){
            $selected ='';
            if($key == $filter){
                $selected = 'selected';
            }
            printf("<option value='%s' %s> %s</option>",$key,$selected,$option);
        }
        ?>
        </select>
        <?php
    ?>
    <?php
    }
 }
 add_action( 'restrict_manage_posts', 'manage_thumbnail_filter');
 function filter_get_post_thumbnail($wpquery){
    if(!is_admin()){
        return;
    }
    $filter = isset($_GET['demothumbnail']) ? $_GET['demothumbnail'] : '';
    if('1'==$filter){
        $wpquery->set('meta_query',array(
            array(
                'key' => '_thumbnail_id',
                'compare' => 'EXISTS'
            ) 
        ));
    }elseif('2' == $filter){
        $wpquery->set('meta_query',array(
            array(
                'key' => '_thumbnail_id',
                'compare' => 'NOT EXISTS'
            ) 
        ));
    }
 }
 add_action( 'pre_get_posts','filter_get_post_thumbnail');

?>