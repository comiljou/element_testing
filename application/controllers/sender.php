<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Sender script controller, designed to create RSA keys, generate test XML request, encode it and send
 *
 */
class Sender extends CI_Controller {

    /**
     * Default method, shows sender form
     *
     */

    public function index()
    {
        $data['template'] = 'sender';
        $this->load->view('template', $data);
    }

    /**
     * Method triggered by ajax call, generates keys on specified path
     *
     */
    public function ajax_generate_keys()
    {
        $this->load->library('crypter');

        echo $this->crypter->generateKeys( );
    }


    /**
     *  Method triggered by ajax call, generate, encrypt and send xml to receiver
     *
     */
    public function ajax_send_xml()
    {

        $this->load->model('Generator_xml');
        $this->load->library('crypter');

        $xml = $this->Generator_xml->generateXML('xml_template');
        if(!$encrypted = $this->crypter->encryptString($xml))
        {
            echo 'Encryption failed, please try to generate keys first';
            die();
        }

        $response = $this->createPostRequest(base64_encode($encrypted));
        echo $response;

    }


    /**
     *
     * CURL request sender function
     *
     * @param $encrypted_xml
     * @return mixed
     */
    private function createPostRequest($encrypted_xml)
    {

        $this->config->load('crypter');

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->config->item('request_url'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('encrypted_xml' => $encrypted_xml)));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        curl_close ($ch);

        return $response;
    }

}
