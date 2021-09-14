<?php

/*
This file is subject to the terms and conditions defined in the "LICENSE.txt"
file, which is part of this source code package and is also available on the
page: https://raw.githubusercontent.com/ocmod-space/license/main/LICENSE.txt.
*/

class ModelExtensionModuleCustomerGroupSize extends Model {
	public function getCustomerGroupSize($customer_group_id) {
		$query = $this->db->query(
            'SELECT COUNT(*) as `size` ' .
            'FROM `' . DB_PREFIX . 'customer` ' .
            'WHERE ' .
            '`customer_group_id` = "' . (int)$customer_group_id . '"'
        );

		return $query->row['size'];
	}
}
