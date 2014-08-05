<?php

namespace Api;

/**
 * Seller callbacks controller.
 */
class Controller_Sellers_Callbacks extends Controller
{
	/**
	 * Gets one or more seller callbacks.
	 *
	 * @param int $seller_id Seller ID.
	 * @param int $id        Callback ID.
	 *
	 * @return void
	 */
	public function get_index($seller_id = null, $id = null)
	{
		if (!$id) {
			$callbacks = \Service_Seller_Callback::find(array(
				'seller' => \Seller::active(),
			));
		} else {
			$callbacks = $this->get_callback($id);
		}
		
		$this->response($callbacks);
	}
	
	/**
	 * Creates a seller callback.
	 *
	 * @param int $seller_id Seller ID.
	 *
	 * @return void
	 */
	public function post_index($seller_id = null)
	{
		$validator = \Validation_Seller_Callback::create();
		if (!$validator->run()) {
			throw new HttpBadRequestException($validator->errors());
		}
		
		$data = $validator->validated();
		
		$event = \Service_Event::find_one(array('name' => $data['event']));
		
		$callback = \Service_Seller_Callback::create(\Seller::active(), $event, $data['url']);
		if (!$callback) {
			throw new HttpServerErrorException;
		}
		
		$this->response($callback);
	}
	
	/**
	 * Updates a seller callback.
	 *
	 * @param int $seller_id Seller ID.
	 * @param int $id        Seller callback ID.
	 *
	 * @return void
	 */
	public function put_index($seller_id = null, $id = null)
	{
		$callback = $this->get_callback($id);
		
		$validator = \Validation_Seller_Callback::update();
		if (!$validator->run(\Input::put())) {
			throw new HttpBadRequestException($validator->errors());
		}
		
		$data = $validator->validated();
		
		$callback = \Service_Seller_Callback::update($callback, $data);
		if (!$callback) {
			throw new HttpServerErrorException;
		}
		
		$this->response($callback);
	}
	
	/**
	 * Deletes a seller callback.
	 *
	 * @param int $seller_id Seller ID.
	 * @param int $id        Seller callback ID.
	 *
	 * @return void
	 */
	public function delete_index($seller_id = null, $id = null)
	{
		$callback = $this->get_callback($id);
		
		$deleted = \Service_Seller_Callback::delete($callback);
		if (!$deleted) {
			throw new HttpServerErrorException;
		}
	}
	
	/**
	 * Attempts to get a seller callback from a given ID.
	 *
	 * @param int $id Seller callback ID.
	 *
	 * @return \Model_Seller_Callback
	 */
	protected function get_callback($id)
	{
		if (!$id) {
			throw new HttpNotFoundException;
		}
		
		$callback = \Service_Seller_Callback::find_one(array(
			'id'     => $id,
			'seller' => \Seller::active(),
		));
		
		if (!$callback) {
			throw new HttpNotFoundException;
		}
		
		return $callback;
	}
}
