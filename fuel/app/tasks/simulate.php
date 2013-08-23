<?php

namespace Fuel\Tasks;

/**
 * Simulate task.
 *
 * @author Daniel Sposito <dsposito@static.com>
 */
class Simulate
{
	const TOTAL_CUSTOMERS = 500;
	
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
	 * Run setup:reset to reset database.
	 *
	 * @return void
	 */
	public static function run()
	{
		self::sellers();
		
		self::products();
		
		self::customers();
		
		\Cli::write('All Simulations Complete', 'green');
	}
	
	protected static function sellers()
	{
		// July 1st, 2013.
		$date = date("Y-m-d H:i:s", 1372636800);
		
		$companies = array('Catalog', 'Static');
		foreach ($companies as $company) {
			$seller = \Service_Seller::create($company, array(
				'contact'    => array(
					'company_name' => "$company.com, Inc",
					'email'        => "support@$company.com",
					'address'      => mt_rand(1, 5000) . ' Quail Springs Pkwy',
					'city'         => 'Oklahoma City',
					'state'        => 'Oklahoma',
					'zip'          => mt_rand(10000, 99999),
					'country'      => 'US',
					'created_at'   => $date,
					'updated_at'   => $date,
				),
				'created_at' => $date,
				'updated_at' => $date,
			));
			
			if ($seller) {
				self::$sellers[] = $seller;
			}
		}
		
		\Cli::write('Seller Simulation Complete', 'green');
	}
	
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
	
	protected static function customers()
	{
		$balances = array(0, 5, 10, 12.50, 24.30);
		
		$first_names = array('Daniel', 'Steve', 'Elon', 'Bill', 'Stephen', 'Olivia', 'Mae', 'Caroline', 'Porschia', 'Marie');
		$last_names  = array('Sposito', 'Jacobson', 'Jenkins', 'Gates', 'Jobs', 'Musk', 'Smith', 'Wyrick', 'Natalie', 'Stevens');
		
		$streets = array('Wisteria Ln', 'Pebble Creek Blvd', 'Bakerstreet Dr', 'Miranda Point', 'Infinite Loop');
		$cities  = array('Oklahoma City', 'Phoenix', 'Palo Alto', 'Saigon', 'Caracas');
		$states  = array('OK', 'NY', 'CA', 'WA', 'FL');
		$countries = array('US', 'VN', 'VZ');
		
		$customers = array();
		
		for ($i = 1; $i <= self::TOTAL_CUSTOMERS; $i++) {
			$first_name = $first_names[array_rand($first_names)];
			$last_name  = $last_names[array_rand($last_names)];
			
			// Random created_at between July 1st, 2013 and August 31st, 2013.
			$date = date("Y-m-d H:i:s", mt_rand(1372636800, 1377907200));
			
			$customers[] = array(
				'balance'    => $balances[array_rand($balances)],
				'contact'    => array(
					'first_name' => $first_name,
					'last_name'  => $last_name,
					'email'      => $first_name . '.' . $last_name . mt_rand(1, 100) . '@catalog.com',
					'address'    => mt_rand(1, 5000) . ' ' . $streets[array_rand($streets)],
					'city'       => $cities[array_rand($cities)],
					'state'      => $states[array_rand($states)],
					'zip'        => mt_rand(10000, 99999),
					'country'    => $countries[array_rand($countries)],
					'created_at' => $date,
					'updated_at' => $date,
				),
				'status'     => mt_rand(1, 10) <= 8 ? 'active' : 'deleted',
				'created_at' => $date,
				'updated_at' => $date,
			);
		}
		
		foreach ($customers as $data) {
			$seller = self::$sellers[array_rand(self::$sellers)];
			
			$customer = \Service_Customer::create($seller, $data);
			
			// Subscribe a random number of customers to a product option.
			if ($customer && mt_rand(1, 10) >= 5) {
				$option = self::$product_options[$seller->id][array_rand(self::$product_options[$seller->id])];
				
				\Service_Customer_Product_Option::create(
					'My ' . \Str::random('alpha', 5),
					$customer,
					$option,
					array(
						'status'     => mt_rand(1, 10) <= 8 ? 'active' : 'canceled',
						'created_at' => $customer->created_at,
						'updated_at' => $customer->updated_at,
					)
				);
			}
		}
		
		\Cli::write('Customer Simulation Complete', 'green');
	}
}
