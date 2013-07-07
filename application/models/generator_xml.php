<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Generator_xml extends CI_Model{
    const hid_length = 26;

    function __construct()
    {

    }

    function generateHID()
    {
        return strtoupper(substr(md5(rand(0, 10000000000)),0, self :: hid_length));
    }


    function generateIP()
    {
        return sprintf("%d.%d.%d.%d", rand(0, 255), rand(0, 255), rand(0, 255), rand(0, 255));
    }


    /**
     *  Generates dummy XML
     *
     * @param $template_name
     * @return string
     */

    function generateXML($template_name)
    {

        if(empty($template_name))
        {
            trigger_error('No xml tempalate specified', E_USER_WARNING);
            return "";
        }

        $data['hid'] = $this->generateHID();
        $data['ip'] = $this->generateIP();
        $data['datetime'] = date('Y-m-d\TH:i:s');
        $data['productID'] = rand(0,99999999999);
        $data['status'] = 'completed';


        return $this->load->view('xml_template', $data, true);

    }


    /**
     *
     * Simple XML parser method
     * @param $xmlstring
     * @return mixed
     */
    function parseXML($xmlstring)
    {
        $xml = @simplexml_load_string($xmlstring); // don't display parse xml errors
        $json = json_encode($xml);
        return json_decode($json,TRUE);
    }

}