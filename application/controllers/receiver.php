<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Receiver extends CI_Controller {

    /**
     * Receiver script controller, designed get RSA encoded XML, decode it and put it to database
     *
     */
    public function index()
    {
        $this->load->library('crypter');
        $this->load->model('Generator_xml');
        $this->load->model('Data_storage');

        $encrypted_xml  = base64_decode($this->input->post('encrypted_xml'));
        $decrypted = $this->crypter->decryptString($encrypted_xml);

        if(empty($decrypted))
        {
            $result['status'] = 0;
            $result['error'] = 'Receiver :: index - Failed to decode XML';
            echo json_encode($result); die();
        }

        $array = $this->Generator_xml->parseXML($decrypted);

        if(empty($array) || !is_array($array))
        {
            $result['status'] = 0;
            $result['error'] = 'Receiver :: index - Failed to parse XML';
            echo json_encode($result); die();
        }

        foreach($array as $data)
        {
           $result = $this->Data_storage->storeItem($data);
           echo json_encode($result); die(); // only one element in test task, no sense to iterate
        }
    }
}
