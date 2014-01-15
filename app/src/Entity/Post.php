<?php
namespace Entity;
use Spot\Entity;

class Post extends Entity
{
      // Table
    protected static $_datasource = "posts";

    /**
     * Fields
     */
    public static function fields()
    {
        return array(
            'id'           => array('type' => 'int', 'primary' => true, 'serial' => true),
            'status'       => array('type' => 'int', 'required' => true, 'options' => ['draft', 'published'], 'index' => true),
            'title'        => array('type' => 'string', 'required' => true),
            'body'         => array('type' => 'text', 'required' => true),
            'date_created' => array('type' => 'datetime', 'default' => new \DateTime())
        );
    }

    /**
     * Relations
     */
    public static function relations()
    {
        return array(
            'comments' => array(
                'type' => 'HasMany',
                'entity' => 'Entity\Comment',
                'where' => array('id' => ':entity.post_id')
            )
        );
    }
}
