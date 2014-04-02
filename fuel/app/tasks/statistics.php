<?php

namespace Fuel\Tasks;

/**
 * Statistics task.
 */
class Statistics
{
	/**
	 * Processes all statistic calculations.
	 *
	 * @return void
	 */
	public static function run()
	{
		self::customer();
		
		\Cli::write('All Statistical Calculations Complete', 'green');
	}
	
	/**
	 * Processes customer statistics.
	 *
	 * @return void
	 */
	public static function customer()
	{
		if (!$task = \Service_Statistic_Task::begin('customer')) {
			return false;
		}
		
		$data = array();
		
		$date_ranges = \Service_Statistic_Task::date_ranges('customer');
		foreach ($date_ranges as $range) {
			$begin = \Date::create_from_string($range['begin'], 'mysql');
			$end   = \Date::create_from_string($range['end'], 'mysql');
			$date  = $begin->format('mysql_date');
			
			$data[$date] = array();
			
			$created = \Service_Customer_Statistic::created($begin, $end);
			foreach ($created as $result) {
				$data[$date][] = array(
					'seller_id' => $result['seller_id'],
					'name'      => 'created',
					'value'     => $result['total'],
				);
			}
			
			$deleted = \Service_Customer_Statistic::deleted($begin, $end);
			foreach ($deleted as $result) {
				$data[$date][] = array(
					'seller_id' => $result['seller_id'],
					'name'      => 'deleted',
					'value'     => $result['total'],
				);
			}
			
			$subscribed = \Service_Customer_Statistic::subscribed($begin, $end);
			foreach ($subscribed as $result) {
				$data[$date][] = array(
					'seller_id' => $result['seller_id'],
					'name'      => 'subscribed',
					'value'     => $result['total'],
				);
			}
			
			$unsubscribed = \Service_Customer_Statistic::unsubscribed($begin, $end);
			foreach ($unsubscribed as $result) {
				$data[$date][] = array(
					'seller_id' => $result['seller_id'],
					'name'      => 'unsubscribed',
					'value'     => $result['total'],
				);
			}
			
			$total = \Service_Customer_Statistic::total($end);
			foreach ($total as $result) {
				$data[$date][] = array(
					'seller_id' => $result['seller_id'],
					'name'      => 'total',
					'value'     => $result['total'],
				);
			}
			
			$total_active = \Service_Customer_Statistic::total_active($end);
			foreach ($total_active as $result) {
				$data[$date][] = array(
					'seller_id' => $result['seller_id'],
					'name'      => 'total_active',
					'value'     => $result['total'],
				);
			}
			
			$total_subscribed = \Service_Customer_Statistic::total_subscribed($end);
			foreach ($total_subscribed as $result) {
				$data[$date][] = array(
					'seller_id' => $result['seller_id'],
					'name'      => 'total_subscribed',
					'value'     => $result['total'],
				);
			}
		}
		
		// Save the queried results as statistics.
		foreach ($data as $date => $results) {
			$date = \Date::create_from_string($date, 'mysql_date');
			
			foreach ($results as $result) {
				$seller = \Service_Seller::find_one($result['seller_id']);
				
				if (!\Service_Statistic::create($seller, 'customer', $date, $result['name'], $result['value'])) {
					\Service_Statistic_Task::end($task, 'failed', "Error creating customer.{$result['name']} statistic for seller {$seller->name}.");
					return;
				}
			}
		}
		
		\Service_Statistic_Task::end($task);
		
		\Cli::write('Customer Statistical Calculations Complete', 'green');
	}
}
