<?php

/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 24.09.14
 * Time: 13:24
 */
class UsersTagsWidget extends QWidget
{

    private $tags_table = 'users_tags';
    protected $_entity_tags = false;
    public $id = 'tags-widget';

    protected $_entity;
    protected $_entity_id;

    public function run()
    {
        Yii::app()->clientScript->registerScriptFile('/js/XTags.js');
    }

    public function getEntityTags($entity_name, $entity_id, $user_id)
    {
        if($this->_entity_tags !== false){
            return $this->_entity_tags;
        }
        $sql = "
            SELECT ut.* FROM users_tags ut
            INNER JOIN cross_links cl ON (cl.link_table_id = ut.id)
            WHERE cl.user_id = :user_id AND cl.link_table_name = :table_name
            AND (ut.user_id = :user_id OR ut.user_id IS NULL)
            AND cl.entity_name = :entity_name
            AND cl.entity_id = :entity_id
        ";

        $model = Users_Tags::model()->findAllBySql(
            $sql,
            array(
                ':user_id' => $user_id,
                ':table_name' => $this->tags_table,
                ':entity_name' => $entity_name,
                ':entity_id' => $entity_id,
            )
        );

        foreach($model as $tag){
            $this->_entity_tags[$tag->id] = $tag;
        }

        return $this->_entity_tags;
    }

    public function renderTransactionTags($transaction_id, $return = false)
    {
        if(!$return){
            $this->registerScript();
        }
        $this->_entity = 'transactions';
        $this->_entity_id = $transaction_id;

        $tags = $this->getEntityTags($this->_entity, $transaction_id, Yii::user()->getCurrentId());

        return $this->render(
            'UsersTagsWidget/transactionsTags',
            array('tags' => $tags, 'transaction_id' => $transaction_id),
            $return
        );
    }

    public function getCurrentUserTags()
    {
        $tags = Users_Tags::model()->findAllBySql('SELECT ut.*, count(ut.id) as ctags FROM users_tags ut
            LEFT OUTER JOIN cross_links cl ON (cl.link_table_id = ut.id)
            WHERE (cl.user_id = :uid AND ut.user_id = :uid AND cl.link_table_name = "users_tags") OR (ut.user_id is null)
            GROUP BY ut.id
            ORDER BY ctags DESC, ut.id ASC
            LIMIT 15',
            array(':uid' => Yii::user()->getCurrentId(), ':table_name' => $this->tags_table)
        );
		
        return $tags;
    }

    public function renderUserTopTags($return = false)
    {
        if(!$return){
            $this->registerScript();
        }
        $tags = $this->getCurrentUserTags();

        return $this->render('UsersTagsWidget/userTopTags', array('tags' => $tags), $return);
    }

    public function registerScript()
    {

    }
}