<?php

/**
 * Product meta option model.
 */
class Model_Product_Meta_Option extends Model
{
    protected static $_properties = array(
        'id',
        'product_meta_id',
        'value',
        'created_at',
        'updated_at',
    );
    
    protected static $_observers = array(
        'Orm\Observer_CreatedAt' => array(
            'events' => array('before_insert'),
            'mysql_timestamp' => true,
        ),
        'Orm\Observer_UpdatedAt' => array(
            'events' => array('before_save'),
            'mysql_timestamp' => true,
        ),
    );
    
    protected static $_belongs_to = array(
        'meta' => array(
            'model_to' => 'Model_Product_Meta',
        ),
    );
}
