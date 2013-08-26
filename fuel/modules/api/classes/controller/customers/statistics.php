<?php

namespace Api;

/**
 * Customer statistics controller.
 * 
 * @author Daniel Sposito <dsposito@static.com>
 */
class Controller_Customers_Statistics extends Controller
{
	/**
	 * Gets customer activity statistics.
	 *
	 * @return void
	 */
	public function get_activity()
	{
		$names = array('created', 'deleted', 'subscribed', 'unsubscribed');
		
		$statistics = \Service_Statistic::find(array(
			'seller' => \Seller::active(),
			'type'   => 'customer',
			'name'   => $names,
		));
		
		$data = array();
		foreach ($statistics as $stat) {
			$data[$stat->date][$stat->name] = (int) $stat->value;
		}
		
		// Fill in any missing data.
		foreach ($data as $date => $stats) {
			foreach ($names as $name) {
				if (!\Arr::get($stats, $name)) {
					$data[$date][$name] = 0;
				}
			}
			
			ksort($data[$date]);
		}
		
		$this->response($data);
	}
	
	/**
	 * Gets customer totals statistics.
	 *
	 * @return void
	 */
	public function get_totals()
	{
		$names = array('total', 'total_active', 'total_subscribed');
		
		$statistics = \Service_Statistic::find(array(
			'seller' => \Seller::active(),
			'type'   => 'customer',
			'name'   => $names,
		));
		
		$data = array();
		foreach ($statistics as $stat) {
			$data[$stat->date][$stat->name] = (int) $stat->value;
		}
		
		// Fill in any missing data.
		foreach ($data as $date => $stats) {
			foreach ($names as $name) {
				if (!\Arr::get($stats, $name)) {
					$data[$date][$name] = 0;
				}
			}
			
			ksort($data[$date]);
		}
		
		$this->response($data);
	}
	
	/**
	 * Gets customer conversion statistics.
	 *
	 * @return void
	 */
	public function get_conversion()
	{
		$names = array('total', 'total_active', 'total_subscribed');
		
		$statistics = \Service_Statistic::recent(array(
			'seller' => \Seller::active(),
			'type'   => 'customer',
			'name'   => $names,
		));
		
		$data = array();
		foreach ($statistics as $stat) {
			$date = $stat->date;
			$data[$date][$stat->name] = (int) $stat->value;
		}
		
		ksort($data[$date]);
		
		$this->response($data);
	}
}
