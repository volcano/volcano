<?php

namespace Api;

/**
 * Product meta options controller.
 */
class Controller_Products_Metas_Options extends Controller
{
	/**
	 * Gets one or more product meta options.
	 *
	 * @param int $meta_id Product meta ID.
	 * @param int $id      Product meta option ID.
	 *
	 * @return void
	 */
	public function get_index($meta_id = null, $id = null)
	{
		$meta = $this->get_meta($meta_id);
		
		if (!$id) {
			$options = \Service_Product_Meta_Option::find(array(
				'meta' => $meta,
			));
		} else {
			$options = $this->get_option($id, $meta);
		}
		
		$this->response($options);
	}
	
	/**
	 * Creates a product meta option.
	 *
	 * @param int $meta_id Product meta ID.
	 *
	 * @return void
	 */
	public function post_index($meta_id = null)
	{
		$meta = $this->get_meta($meta_id);
		
		$validator = \Validation_Product_Meta_Option::create();
		if (!$validator->run()) {
			throw new HttpBadRequestException($validator->errors());
		}
		
		$data = $validator->validated();
		
		$option = \Service_Product_Meta_Option::create($data['value'], $meta);
		if (!$option) {
			throw new HttpServerErrorException;
		}
		
		$this->response($option);
	}
	
	/**
	 * Updates a product meta option.
	 *
	 * @param int $meta_id Product meta ID.
	 * @param int $id      Product meta option ID.
	 *
	 * @return void
	 */
	public function put_index($meta_id = null, $id = null)
	{
		$meta   = $this->get_meta($meta_id);
		$option = $this->get_option($id, $meta);
		
		$validator = \Validation_Product_Meta_Option::update();
		if (!$validator->run(\Input::put())) {
			throw new HttpBadRequestException($validator->errors());
		}
		
		$data = $validator->validated();
		
		$option = \Service_Product_Meta_Option::update($option, $data);
		if (!$option) {
			throw new HttpServerErrorException;
		}
		
		$this->response($option);
	}
	
	/**
	 * Attempts to get a product meta from a given ID.
	 *
	 * @param int $id Product meta ID.
	 *
	 * @return \Model_Product_Meta
	 */
	protected function get_meta($id)
	{
		if (!$id) {
			throw new HttpNotFoundException;
		}
		
		$meta = \Service_Product_Meta::find_one($id);
		if (!$meta || $meta->product->seller != \Seller::active()) {
			throw new HttpNotFoundException;
		}
		
		return $meta;
	}
	
	/**
	 * Attempts to get a product meta option from a given ID.
	 *
	 * @param int                 $id   Product meta option ID.
	 * @param \Model_Product_Meta $meta Product meta the option should belong to.
	 *
	 * @return \Model_Product_Meta_Option
	 */
	protected function get_option($id, \Model_Product_Meta $meta)
	{
		if (!$id) {
			throw new HttpNotFoundException;
		}
		
		$option = \Service_Product_Meta_Option::find_one($id);
		if (!$option || $option->meta != $meta || $option->meta->product->seller != \Seller::active()) {
			throw new HttpNotFoundException;
		}
		
		return $option;
	}
}
