<?php

namespace Fuel\Tasks;

/**
 * Handles recurring fees for customer product subscriptions.
 */
class Recurring
{
	/**
	 * Processes all recurring processes.
	 *
	 * @return void
	 */
	public static function run()
	{
		self::monthly();
		
		self::yearly();
		
		\Cli::write('All Recurring Processes Complete', 'green');
	}

	/**
	 * Handles monthly recurring fees.
	 *
	 * @return void
	 */
	public static function monthly()
	{
		// @TODO Retrieve all customer_product_options created/updated (new last_billed_at field?) 1 month ago.
		
		// @TODO Group customer_product_option results by customer.
		
		// @TODO Create transaction for the sum amount of each customer's product option fees.
		//       Support price grandfathering by retrieving the transaction amount from the original order.
		
		// @TODO Handle pro-rating, customer balance/credits, etc.
	}

	/**
	 * Handles yearly recurring fees.
	 *
	 * @return void
	 */
	public static function yearly()
	{
		// @TODO Retrieve all customer_product_options created/updated (new last_billed_at field?) 1 year ago.
		
		// @TODO Group customer_product_option results by customer.
		
		// @TODO Create transaction for the sum amount of each customer's product option fees.
		//       Support price grandfathering by retrieving the transaction amount from the original order.
		
		// @TODO Handle pro-rating, customer balance/credits, etc.
	}
}
