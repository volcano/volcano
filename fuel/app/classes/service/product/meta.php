<?php

/**
 * Product meta service.
 */
class Service_Product_Meta extends Service
{
    /**
     * Query models based on optional filters passed in.
     *
     * @param array $args The optional data to use.
     *
     * @return Query
     */
    protected static function query(array $args = array())
    {
        $metas = Model_Product_Meta::query();
        
        if (!empty($args['id'])) {
            $metas->where('id', $args['id']);
        }
        
        if (!empty($args['product'])) {
            $metas->related('product');
            $metas->where('product.id', $args['product']->id);
        }
        
        return $metas;
    }
    
    /**
     * Creates a new product meta.
     *
     * @param string        $name    The name of the product meta.
     * @param Model_Product $product The product the meta belongs to.
     *
     * @return Model_Product_Meta
     */
    public static function create($name, Model_Product $product)
    {
        $meta = Model_Product_Meta::forge();
        $meta->name    = $name;
        $meta->product = $product;
        
        try {
            $meta->save();
        } catch (FuelException $e) {
            Log::error($e);
            return false;
        }
        
        Service_Event::trigger('product.meta.create', $meta->product->seller, $meta->to_array());
        
        return $meta;
    }
    
    /**
     * Updates a product meta.
     *
     * @param Model_Product_Meta $meta The product meta to update.
     * @param array              $data The data to use to update the product meta.
     *
     * @return Model_Product_Meta
     */
    public static function update(Model_Product_Meta $meta, array $data = array())
    {
        $meta->populate($data);
        
        try {
            $meta->save();
        } catch (FuelException $e) {
            Log::error($e);
            return false;
        }
        
        Service_Event::trigger('product.meta.update', $meta->product->seller, $meta->to_array());
        
        return $meta;
    }
}
