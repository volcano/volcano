<?php

/**
 * Validation product meta option class.
 */
class Validation_Product_Meta_Option
{
    /**
     * Creates a new validation instance for product meta option create.
     *
     * @return Validation
     */
    public static function create()
    {
        if (!$validator = Validation::instance('product_meta_option')) {
            $validator = Validation::forge('product_meta_option');
        }
        
        $validator->add('value', 'Value')->add_rule('trim')->add_rule('required');
        
        return $validator;
    }
    
    /**
     * Creates a new validation instance for product meta option update.
     *
     * @return Validation
     */
    public static function update()
    {
        if (!$validator = Validation::instance('product_meta_option')) {
            $validator = Validation::forge('product_meta_option');
        }
        
        $input = Input::param();
        
        if (array_key_exists('value', $input)) {
            $validator->add('value', 'Value')->add_rule('trim')->add_rule('required');
        }
        
        return $validator;
    }
}
