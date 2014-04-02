<?php

namespace Api;

/**
 * Seller events controller.
 */
class Controller_Sellers_Events extends Controller
{
	/**
	 * Gets one or more seller events.
	 *
	 * @param int $seller_id Seller ID.
	 * @param int $id        Event ID.
	 *
	 * @return void
	 */
	public function get_index($seller_id = null, $id = null)
	{
		if (!$id) {
			$seller_events = \Service_Seller_Event::find(array(
				'seller' => \Seller::active(),
			));
		} else {
			$seller_events = $this->get_event($id);
		}
		
		$this->response($seller_events);
	}
	
	/**
	 * Creates a seller event.
	 *
	 * @param int $seller_id Seller ID.
	 *
	 * @return void
	 */
	public function post_index($seller_id = null)
	{
		$validator = \Validation_Seller_Event::create();
		if (!$validator->run()) {
			throw new HttpBadRequestException($validator->errors());
		}
		
		$data = $validator->validated();
		
		$event = \Service_Event::find_one(array('name' => $data['event']));
		
		$seller_event = \Service_Seller_Event::create(\Seller::active(), $event, $data['callback']);
		if (!$seller_event) {
			throw new HttpServerErrorException;
		}
		
		$this->response($seller_event);
	}
	
	/**
	 * Updates a seller event.
	 *
	 * @param int $seller_id Seller ID.
	 * @param int $id        Seller event ID.
	 *
	 * @return void
	 */
	public function put_index($seller_id = null, $id = null)
	{
		$seller_event = $this->get_event($id);
		
		$validator = \Validation_Seller_Event::update();
		if (!$validator->run(\Input::put())) {
			throw new HttpBadRequestException($validator->errors());
		}
		
		$data = $validator->validated();
		
		$seller_event = \Service_Seller_Event::update($seller_event, $data);
		if (!$seller_event) {
			throw new HttpServerErrorException;
		}
		
		$this->response($seller_event);
	}
	
	/**
	 * Deletes a seller event.
	 *
	 * @param int $seller_id Seller ID.
	 * @param int $id        Seller event ID.
	 *
	 * @return void
	 */
	public function delete_index($seller_id = null, $id = null)
	{
		$seller_event = $this->get_event($id);
		
		$deleted = \Service_Seller_Event::delete($seller_event);
		if (!$deleted) {
			throw new HttpServerErrorException;
		}
	}
	
	/**
	 * Attempts to get a seller event from a given ID.
	 *
	 * @param int $id Seller event ID.
	 *
	 * @return \Model_Seller_Event
	 */
	protected function get_event($id)
	{
		if (!$id) {
			throw new HttpNotFoundException;
		}
		
		$seller_event = \Service_Seller_Event::find_one(array(
			'id'     => $id,
			'seller' => \Seller::active(),
		));
		
		if (!$seller_event) {
			throw new HttpNotFoundException;
		}
		
		return $seller_event;
	}
}
