<?php

/**
 * Description of GetStats
 *
 * @author mrl
 */
class GetStats  extends CI_Controller {
	public function index()
	{
            log_message("info", "Getting statistics");
            log_message("debug", "Loading DB Utility class");
            $this->load->database();
            $output = new stdClass();
            $t15m_ago = new DateTime("15 minutes ago");
            $s = $t15m_ago->format("Y-m-d H:i:s");
            $sql = "SELECT count(*) AS COUNT from mo where created_at > '$s'";
            log_message("debug", "Query-ing DB with SQL=$sql");
            $query = $this->db->query($sql);
            $row = $query->row();
            $output->last_15_min_mo_count = $row->COUNT;
            $sql = "SELECT min(created_at) AS MIN, max(created_at) AS MAX from mo order by id DESC limit 10000";
            log_message("debug", "Query-ing DB with SQL=$sql");
            $query = $this->db->query($sql);
            $row = $query->row();
            $output->time_span_last_10k = array($row->MIN,$row->MAX);
            $output_json = json_encode($output);
            log_message("info", "Returning result ====> $output_json");
            $this->output->set_content_type('application/json')->set_output($output_json);
	}
}


