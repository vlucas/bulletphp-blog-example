<?php
namespace Entity;
use Spot\Entity;
use Spot\EntityInterface;
use Spot\MapperInterface;

class Post extends Entity
{
      // Table
    protected static $table = "posts";

    /**
     * Fields
     */
    public static function fields()
    {
        return [
            'id'           => ['type' => 'integer', 'primary' => true, 'autoincrement' => true],
            'status'       => ['type' => 'integer', 'required' => true, 'options' => ['draft', 'published'], 'index' => true],
            'title'        => ['type' => 'string', 'required' => true],
            'body'         => ['type' => 'text', 'required' => true],
            'date_created' => ['type' => 'datetime', 'value' => new \DateTime()]
        ];
    }

    /**
     * Relations
     */
    public static function relations(MapperInterface $mapper, EntityInterface $entity)
    {
        return [
            'comments' => $mapper->hasMany($entity, 'Entity\Post\Comments', 'post_id')
        ];
    }
}
