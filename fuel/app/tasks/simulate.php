<?php

namespace Fuel\Tasks;

/**
 * Simulate task.
 *
 * @author Daniel Sposito <dsposito@static.com>
 */
class Simulate
{
	/**
	 * July 1st, 2013
	 */
	const BEGIN_DATETIME = 1372636800;
	
	/**
	 * Total number of customers to create.
	 */
	const TOTAL_CUSTOMERS = 2000;
	
	/**
	 * Generated gateway.
	 *
	 * @var Model_Gateway
	 */
	protected static $gateway;
	
	/**
	 * Array of generated sellers.
	 *
	 * @var array
	 */
	protected static $sellers = array();
	
	/**
	 * Array of generated product options.
	 * Array key is the ID of the seller the product option belongs to.
	 *
	 * @var array
	 */
	protected static $product_options = array();
	
	/**
	 * Populates the database with dummy data.
	 * Run setup:reset to revert (WARNING: This wipes the entire database).
	 *
	 * @return void
	 */
	public static function run()
	{
		self::gateway();
		
		self::sellers();
		
		self::products();
		
		self::customers();
		
		\Cli::write('All Simulations Complete', 'green');
	}
	
	/**
	 * Generates an internal-only gateway.
	 *
	 * @return void
	 */
	protected static function gateway()
	{
		self::$gateway = \Service_Gateway::create('credit_card', 'none');
		
		\Cli::write('Gateway Simulation Complete', 'green');
	}
	
	/**
	 * Generates sellers.
	 *
	 * @return void
	 */
	protected static function sellers()
	{
		$date = date("Y-m-d H:i:s", self::BEGIN_DATETIME);
		
		$companies = array('Stella Labs, Inc', 'Star Point Industries');
		foreach ($companies as $company) {
			$seller = \Service_Seller::create($company, array(
				'contact' => array(
					'company_name' => $company,
					'email'        => 'support@' . \Inflector::friendly_title($company) . '.com',
					'address'      => mt_rand(1, 5000) . ' Quail Springs Pkwy',
					'city'         => 'Oklahoma City',
					'state'        => 'Oklahoma',
					'zip'          => mt_rand(10000, 99999),
					'country'      => 'US',
				),
				'created_at' => $date,
			));
			
			if ($seller) {
				self::$sellers[] = $seller;
				
				// Link the seller to the gateway.
				\Service_Gateway::link(self::$gateway, $seller);
			}
		}
		
		\Cli::write('Seller Simulation Complete', 'green');
	}
	
	/**
	 * Generates products.
	 *
	 * @return void
	 */
	protected static function products()
	{
		foreach (self::$sellers as $seller) {
			$product = \Service_Product::create('Product Line ' . \Str::upper(\Str::random('alpha', 1)), $seller);
			if ($product) {
				for ($i = 1; $i <= 3; $i++) {
					$option = \Service_Product_Option::create('Product ' . \Str::upper(\Str::random('alpha', 1)), $product);
					if ($option) {
						self::$product_options[$seller->id][] = $option;
						\Service_Product_Option_Fee::create('Subscription', 1, 'month', mt_rand(5, 15), $option);
					}
				}
			}
		}
		
		\Cli::write('Product Simulation Complete', 'green');
	}
	
	/**
	 * Generates customers.
	 *
	 * @return void
	 */
	protected static function customers()
	{
		$balances = array(0, 5, 10, 12.50, 24.30);
		
		$first_names = array('Daniel', 'Steve', 'Elon', 'Bill', 'Stephan', 'Olivia', 'Keithia', 'Caroline', 'Porschia', 'Marie');
		$last_names  = array('Sposito', 'Manos', 'Myers', 'Jenkins', 'Gates', 'Jobs', 'Musk', 'Wyrick', 'Natalie', 'Stevens');
		
		$streets   = array('Wisteria Ln', 'Pebble Creek Blvd', 'Bakerstreet Dr', 'Miranda Point', 'Infinite Loop');
		$cities    = array('Oklahoma City', 'Phoenix', 'Palo Alto', 'Saigon', 'Caracas');
		$states    = array('OK', 'NY', 'CA', 'WA', 'FL');
		$countries = array('US', 'VN', 'VE');
		
		$customers = array();
		
		for ($i = 1; $i <= self::TOTAL_CUSTOMERS; $i++) {
			$first_name = $first_names[array_rand($first_names)];
			$last_name  = $last_names[array_rand($last_names)];
			
			// Random created_at between the begin date and now.
			$date = date("Y-m-d H:i:s", mt_rand(self::BEGIN_DATETIME, time()));
			
			$customers[] = array(
				'balance'    => $balances[array_rand($balances)],
				'contact'    => array(
					'first_name' => $first_name,
					'last_name'  => $last_name,
					'email'      => $first_name . '.' . $last_name . mt_rand(1, 100) . '@gmail.com',
					'address'    => mt_rand(1, 5000) . ' ' . $streets[array_rand($streets)],
					'city'       => $cities[array_rand($cities)],
					'state'      => $states[array_rand($states)],
					'zip'        => mt_rand(10000, 99999),
					'country'    => $countries[array_rand($countries)],
				),
				'status'     => mt_rand(1, 10) <= 8 ? 'active' : 'deleted',
				'created_at' => $date,
			);
		}
		
		foreach ($customers as $data) {
			$seller = self::$sellers[array_rand(self::$sellers)];
			
			$customer = \Service_Customer::create($seller, $data);
			
			// Create a payment method for the faux customer.
			$payment_method = \Service_Customer_Paymentmethod::create(
				$customer,
				self::$gateway,
				array(
					'contact' => $data['contact'],
					'account' => array(
						'provider'         => 'Volcano',
						'number'           => '6011000000000012',
						'expiration_month' => '12',
						'expiration_year'  => '5',
					),
				)
			);
			
			// Subscribe a random number of customers to a product option.
			if ($customer && mt_rand(1, 10) >= 5) {
				$option = self::$product_options[$seller->id][array_rand(self::$product_options[$seller->id])];
				
				$order = \Service_Customer_Order::create(
					$customer,
					array($option->id => 'My ' . \Str::random('alpha', 5)),
					null,
					array('created_at' => $customer->created_at)
				);
			}
			
			// Reset the models' updated_at.
			self::updateUpdatedAt($customer);
			self::updateUpdatedAt($order);
			foreach ($customer->products as $product) {
				self::updateUpdatedAt($product);
			}
		}
		
		\Cli::write('Customer Simulation Complete', 'green');
	}
	
	/**
	 * Updates a model's updated_at via manual query.
	 * Fuel does not currently support setting a record's updated_at via the ORM.
	 * This hack is needed in order to allow accurate statistics for simulated data.
	 * 
	 * @param Model $model The model record to update.
	 * 
	 * @return void
	 */
	protected static function updateUpdatedAt(\Model $model)
	{
		\DB::update($model->table())
			->set(array('updated_at' => $model->created_at))
			->where('id', $model->id)
			->execute();
	}
}
