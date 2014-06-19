<?php
/**
 * Created by ekazak.
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * Date: 12.06.14
 * Time: 17:27
 */

class RbackService {

    /**
     * @param $model array RbacAccessRights
     * @return array
     */
    public function getAccessRightsTreeByModel(array $model){
        $rightsTree = array();
        $buff = array();
        foreach ($model as $r) {
            $r = $r->attributes;
            $buff[(int)$r['parent_id']][] = $r;
        }
        return self::_createTree($buff, $buff[0]);
    }

    private static function _createTree(&$list, $parent) {
        $tree = array();
        foreach ($parent as $k => $l){
            if( isset($list[$l['id']]) ){
                $l['children'] = self::_createTree($list, $list[$l['id']]);
            }
            $tree[] = $l;
        }
        return $tree;
    }
} 