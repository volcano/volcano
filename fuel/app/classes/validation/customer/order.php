<?php

/**
 * Validation customer order class.
 */
class Validation_Customer_Order
{
	/**
	 * Creates a new validation instance for order create.
	 *
	 * @param Model_Customer $customer The ordering customer.
	 *
	 * @return Validation
	 */
	public static function create(Model_Customer $customer)
	{
		$validator = Validation::forge('order');
		
		$validator->add('products', 'Products')->add_rule('required')->add_rule(array('invalid_products' => function ($products) use ($customer) {
			$ids = array_keys($products);
			
			foreach ($ids as $id) {
				if (!is_numeric($id)) {
					return false;
				}
				
				$product_option = Service_Product_Option::find_one($id);
				if (!$product_option || $product_option->product->seller != $customer->seller) {
					return false;
				}
			}
			
			return true;
		}));
		
		$validator->add('paymentmethod', 'Paymentmethod')->add_rule(array('invalid_paymentmethod' => function ($paymentmethod) use ($customer) {
			if (!$paymentmethod) {
				return true;
			}
			
			$paymentmethod = Service_Customer_Paymentmethod::find_one($paymentmethod);
			if (!$paymentmethod || $paymentmethod->customer != $customer) {
				return false;
			}
			
			return true;
		}));
		
		return $validator;
	}
}
