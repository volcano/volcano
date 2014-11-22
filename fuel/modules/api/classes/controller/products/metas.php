<?php

namespace Api;

/**
 * Product metas controller.
 */
class Controller_Products_Metas extends Controller
{
    /**
     * Gets one or more product metas.
     *
     * @param int $product_id Product ID.
     * @param int $id         Product meta ID.
     *
     * @return void
     */
    public function get_index($product_id = null, $id = null)
    {
        $product = $this->get_product($product_id);
        
        if (!$id) {
            $metas = \Service_Product_Meta::find(array(
                'product' => $product,
            ));
        } else {
            $metas = $this->get_meta($id, $product);
        }
        
        $this->response($metas);
    }
    
    /**
     * Creates a product meta.
     *
     * @param int $product_id Product ID.
     *
     * @return void
     */
    public function post_index($product_id = null)
    {
        $product = $this->get_product($product_id);
        
        $validator = \Validation_Product_Meta::create();
        if (!$validator->run()) {
            throw new HttpBadRequestException($validator->errors());
        }
        
        $data = $validator->validated();
        
        $meta = \Service_Product_Meta::create($data['name'], $product, $data);
        if (!$meta) {
            throw new HttpServerErrorException;
        }
        
        $this->response($meta);
    }
    
    /**
     * Updates a product meta.
     *
     * @param int $product_id Product ID.
     * @param int $id         Product meta ID.
     *
     * @return void
     */
    public function put_index($product_id = null, $id = null)
    {
        $product = $this->get_product($product_id);
        $meta    = $this->get_meta($id, $product);
        
        $validator = \Validation_Product_Meta::update();
        if (!$validator->run(\Input::put())) {
            throw new HttpBadRequestException($validator->errors());
        }
        
        $data = $validator->validated();
        
        $meta = \Service_Product_Meta::update($meta, $data);
        if (!$meta) {
            throw new HttpServerErrorException;
        }
        
        $this->response($meta);
    }
    
    /**
     * Attempts to get a product from a given ID.
     *
     * @param int $id Product ID.
     *
     * @return \Model_Product
     */
    protected function get_product($id)
    {
        if (!$id) {
            throw new HttpNotFoundException;
        }
        
        $product = \Service_Product::find_one($id);
        if (!$product || $product->seller != \Seller::active()) {
            throw new HttpNotFoundException;
        }
        
        return $product;
    }
    
    /**
     * Attempts to get a product meta from a given ID.
     *
     * @param int            $id      Product meta ID.
     * @param \Model_Product $product Product the meta should belong to.
     *
     * @return \Model_Product_Meta
     */
    protected function get_meta($id, \Model_Product $product)
    {
        if (!$id) {
            throw new HttpNotFoundException;
        }
        
        $meta = \Service_Product_Meta::find_one($id);
        if (!$meta || $meta->product != $product || $meta->product->seller != \Seller::active()) {
            throw new HttpNotFoundException;
        }
        
        return $meta;
    }
}
