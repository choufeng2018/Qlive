<?php


/**
 * @param $media_id
 * @param $term_id
 * 添加或更新多媒体附件分类
 */
function update_media_term($media_id, $term_id){
    update_object_term($media_id,$term_id,'attachment');
}

/**
 * @param $media_id
 * @param $term_id
 * 删除多媒体附件分类
 */
function delete_media_term($media_id, $term_id){
    delete_object_term($media_id,$term_id,'attachment');
}
