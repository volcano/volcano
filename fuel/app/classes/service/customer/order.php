<?php

/**
 * Customer order service.
 */
class Service_Customer_Order extends Service
{
	/**
	 * Query models based on optional filters passed in.
	 *
	 * @param array $options The optional options to use.
	 *
	 * @return Query
	 */
	protected static function query(array $options = array())
	{
		$orders = Model_Customer_Order::query();
		
		if (!empty($options['id'])) {
			$orders->where('id', $options['id']);
		}
		
		if (!empty($options['customer'])) {
			$orders->where('customer_id', $options['customer']->id);
		}
		
		if (!empty($options['status'])) {
			$orders->where('status', $options['status']);
		}
		
		return $orders;
	}
	
	/**
	 * Creates a new customer order.
	 *
	 * @param Model_Customer               $customer      The customer the order belongs to.
	 * @param array                        $products      An array of one or more products to order.
	 * @param Model_Customer_Paymentmethod $paymentmethod The payment method to use for the transaction.
	 * @param array                        $data          Optional data.
	 *
	 * @return Model_Customer_Order
	 */
	public static function create(Model_Customer $customer, array $products, Model_Customer_Paymentmethod $paymentmethod = null, $data = array())
	{
		if ($paymentmethod && $paymentmethod->customer != $customer) {
			return false;
		}
		
		if (!$paymentmethod) {
			// Use the customer's primary payment method if none is provided.
			if (!$paymentmethod = Service_Customer_Paymentmethod::primary($customer)) {
				return false;
			}
		}
		
		$product_options = array();
		$transaction_total = 0;
		foreach ($products as $id => $name) {
			$option = Service_Product_Option::find_one($id);
			if (!$option instanceof Model_Product_Option) {
				continue;
			}
			
			$product_options[] = $option;
			
			$transaction_total += $option->sum_fees();
		}
		
		// Attempt to charge the customer for the order's total.
		if (!$transaction = Service_Customer_Transaction::create($paymentmethod, $transaction_total)) {
			return false;
		}
		
		$order = Model_Customer_Order::forge();
		$order->customer = $customer;
		$order->transaction = $transaction;
		
		$order->populate($data);
		
		try {
			$order->save();
		} catch (FuelException $e) {
			Log::error($e);
			return false;
		}
		
		// Link products to customer.
		foreach ($product_options as $option) {
			Service_Customer_Product_Option::create(Arr::get($products, $option->id), $order, $option, $data);
		}
		
		// Mark the order as completed.
		self::update($order, array('status' => 'completed'));
		
		Service_Event::trigger('customer.order.create', $customer->seller, $order->to_array());
		
		return $order;
	}
	
	/**
	 * Updates a customer order.
	 *
	 * @param Model_Customer_Order $order The order to update.
	 * @param array                $data  The data to use to update the order.
	 *
	 * @return Model_Customer_Order
	 */
	public static function update(Model_Customer_Order $order, array $data = array())
	{
		$order->populate($data);
		
		try {
			$order->save();
		} catch (FuelException $e) {
			Log::error($e);
			return false;
		}
		
		Service_Event::trigger('customer.order.update', $order->customer->seller, $order->to_array());
		
		return $order;
	}
}
