<?php
require_once(APPPATH . '/controllers/test/toast.php');

class SubmitMORequest extends Toast
{
	function __construct()
	{
            parent::__construct(__FILE__);
            // Load any models, libraries etc. you need here
            $this->load->database();
	}

	/**
	 * OPTIONAL; Anything in this function will be run before each test
	 * Good for doing cleanup: resetting sessions, renewing objects, etc.
	 */
	function _pre() {}

	/**
	 * OPTIONAL; Anything in this function will be run after each test
	 * I use it for setting $this->message = $this->My_model->getError();
	 */
	function _post() {}


	/* TESTS BELOW */

        function test_submit_mo_success() 
        {
            $sql = "SELECT count(*) AS COUNT from mo";
            $query = $this->db->query($sql);
            $row = $query->row();
            $old_count = $row->COUNT;
            $curl_handle=curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, "http://localhost/index.php?msisdn=60123456789&operatorid=3&shortcodeid=8&text=ON+GAMES");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
            $html_str = curl_exec($curl_handle);
            curl_close($curl_handle);
            $this->_assert_not_empty($html_str);
            $result_json = json_decode($html_str);
            $this->_assert_equals($result_json->status, "ok");
            sleep(4);
            $query = $this->db->query($sql);
            $row = $query->row();
            $new_count = $row->COUNT;
            $this->_assert_equals($new_count-$old_count, 1);
            $this->message = $row->COUNT."|".$new_count-$old_count;
        }
	
        function test_stats_success() 
        {
            $curl_handle=curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, "http://localhost/stats.php");
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
            $html_str = curl_exec($curl_handle);
            curl_close($curl_handle);
            $this->_assert_not_empty($html_str);
            $this->message = $html_str;
        }
}

// End of file example_test.php */
// Location: ./system/application/controllers/test/example_test.php */