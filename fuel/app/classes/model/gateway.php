<?php

/**
 * Gateway model.
 *
 * @author Keithia Stegmann <kstegmann@static.com>
 */
class Model_Gateway extends Model
{
	protected static $_properties = array(
		'id',
		'type',
		'processor',
		'status' => array('default' => 'active'),
		'created_at',
		'updated_at',
	);
	
	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => true,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_save'),
			'mysql_timestamp' => true,
		),
	);

	protected static $_has_many = array(
		'meta' => array(
		'model_to' => 'Model_Gateway_Meta',
		),
	);

	/**
	* Returns meta data for this gateway instance.
	*
	* @param string $name The meta name to get.
	*
	* @return array|mixed
	*/
	public function meta($name)
	{
		if (is_array($name)) {
			$meta_array = array();
			$metas = Model_Gateway_Meta::query()
			->where('gateway_id', $this->id)
			->where('name', 'in', $name)
			->get();

			foreach ($metas as $meta) {
				$meta_array[$meta->name] = $meta;
			}

			return $meta_array;
		}

		return Model_Gateway_Meta::find_by_gateway_id_and_name($this->id, $name);
	}
}
