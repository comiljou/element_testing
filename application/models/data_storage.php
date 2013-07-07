<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Data_storage
 * DB storage class
 */
class Data_storage extends CI_Model{
    const table = 'stored_data';

    function __construct()
    {
        $this->load->database();
        parent :: __construct();
    }

    /**
     * Simple strore data method
     *
     * @param $array
     * @return mixed
     */
    public function storeItem($array)
    {
        $prepared_data['hid'] = $array['Hid'];
        $prepared_data['date'] = $array['Date'];
        $prepared_data['status'] = $array['Status'];
        $prepared_data['product_id'] = $array['ProductId'];
        $prepared_data['ip'] = ip2long($array['IP']);

        if($this->db->insert(self :: table, $prepared_data))
        {
            $result['status'] = 1;
            $result['id'] = $this->db->insert_id();
            return $result;
        }
        else
        {
            $result['status'] = 0;
            $result['error'] = $this->db->_error_message();
            return $result;
        }


    }
}