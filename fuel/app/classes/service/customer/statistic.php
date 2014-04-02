<?php

/**
 * Customer statistic service.
 */
class Service_Customer_Statistic extends Service
{
	/**
	 * Calculates the total number of customers created in a given date range.
	 *
	 * @param Date $begin Begin date.
	 * @param Date $end   End date.
	 *
	 * @return array
	 */
	public static function created(Date $begin, Date $end)
	{
		// Retrieve total number of customers created during begin/end date range.
		$query = DB::select('seller_id', array(DB::expr('COUNT(1)'), 'total'))
			->from('customers')
			->where('status', 'active')
			->where('created_at', '>=', $begin->format('mysql'))
			->where('created_at', '<=', $end->format('mysql'))
			->group_by('seller_id');
		
		$results = $query->execute();
		
		return $results->as_array();
	}
	
	/**
	 * Calculates the total number of customers deleted in a given date range.
	 *
	 * @param Date $begin Begin date.
	 * @param Date $end   End date.
	 *
	 * @return array
	 */
	public static function deleted(Date $begin, Date $end)
	{
		// Retrieve total number of customers deleted during begin/end date range.
		$query = DB::select('seller_id', array(DB::expr('COUNT(1)'), 'total'))
			->from('customers')
			->where('status', 'deleted')
			->where('updated_at', '>=', $begin->format('mysql'))
			->where('updated_at', '<=', $end->format('mysql'))
			->group_by('seller_id');
		
		$results = $query->execute();
		
		return $results->as_array();
	}
	
	/**
	 * Calculates the total number of customers that bought a product in a given date range.
	 *
	 * @param Date $begin Begin date.
	 * @param Date $end   End date.
	 *
	 * @return array
	 */
	public static function subscribed(Date $begin, Date $end)
	{
		// Retrieve total number of subscriptions created during begin/end date range.
		$query = DB::select('c.seller_id', array(DB::expr('COUNT(DISTINCT customer_id)'), 'total'))
			->from(array('customer_product_options', 'cpo'))
			->join(array('customers', 'c'))->on('cpo.customer_id', '=', 'c.id')
			->where('cpo.status', 'active')
			->where('cpo.created_at', ' >=', $begin->format('mysql'))
			->where('cpo.created_at', ' <=', $end->format('mysql'))
			->group_by('c.seller_id');
		
		$results = $query->execute();
		
		return $results->as_array();
	}
	
	/**
	 * Calculates the total number of customers that canceled a product in a given date range.
	 *
	 * @param Date $begin Begin date.
	 * @param Date $end   End date.
	 *
	 * @return array
	 */
	public static function unsubscribed(Date $begin, Date $end)
	{
		// Retrieve total number of subscriptions canceled during begin/end date range.
		$query = DB::select('c.seller_id', array(DB::expr('COUNT(DISTINCT customer_id)'), 'total'))
			->from(array('customer_product_options', 'cpo'))
			->join(array('customers', 'c'))->on('cpo.customer_id', '=', 'c.id')
			->where('cpo.status', 'canceled')
			->where('cpo.updated_at', ' >=', $begin->format('mysql'))
			->where('cpo.updated_at', ' <=', $end->format('mysql'))
			->group_by('c.seller_id');
		
		$results = $query->execute();
		
		return $results->as_array();
	}
	
	/**
	 * Calculates the total number of customers created prior to a given date.
	 *
	 * @param Date $date End date.
	 *
	 * @return array
	 */
	public static function total(Date $date)
	{
		// Retrieve total number of customers created prior to the specified date.
		$query = DB::select('seller_id', array(DB::expr('COUNT(1)'), 'total'))
			->from('customers')
			->where('updated_at', '<=', $date->format('mysql'))
			->group_by('seller_id');
		
		$results = $query->execute();
		
		return $results->as_array();
	}
	
	/**
	 * Calculates the total number of active customers prior to a given date.
	 *
	 * @param Date $date End date.
	 *
	 * @return array
	 */
	public static function total_active(Date $date)
	{
		// Retrieve total number of customers created prior to the specified date.
		$query = DB::select('seller_id', array(DB::expr('COUNT(1)'), 'total'))
			->from('customers')
			->where('status', 'active')
			->where('updated_at', '<=', $date->format('mysql'))
			->group_by('seller_id');
		
		$results = $query->execute();
		
		return $results->as_array();
	}
	
	/**
	 * Calculates the total number of customers that bought a product prior to a given date.
	 *
	 * @param Date $date End date.
	 *
	 * @return array
	 */
	public static function total_subscribed(Date $date)
	{
		// Retrieve total number of subscriptions created during begin/end date.
		$query = DB::select('c.seller_id', array(DB::expr('COUNT(DISTINCT customer_id)'), 'total'))
			->from(array('customer_product_options', 'cpo'))
			->join(array('customers', 'c'))->on('cpo.customer_id', '=', 'c.id')
			->where('cpo.status', 'active')
			->where('cpo.updated_at', ' <=', $date->format('mysql'))
			->group_by('c.seller_id');
		
		$results = $query->execute();
		
		return $results->as_array();
	}
}
