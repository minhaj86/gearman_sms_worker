<?php

/**
 * Description of SubmitMORequest
 *
 * @author mrl
 */
class SubmitMORequest  extends CI_Controller {
	public function index()
	{
            log_message("info", "Submitting MO Request");
            $input = new stdClass();
            log_message("debug", "Fetching HTTP query parameters");
            $input->msisdn = $this->input->get("msisdn");
            $input->operatorid = $this->input->get("operatorid");
            $input->shortcodeid = $this->input->get("shortcodeid");
            $input->text = $this->input->get("text");
            log_message("debug", "HTTP query parameter found ===> ". json_encode($input));
            log_message("debug", "Creating new Gearman client");
            $client = new GearmanClient();
            log_message("debug", "Associating Gearman server with client");
            $client->addServer();
            log_message("debug", "Submitting job to Gearman server to work in backend");
            $client->doBackground("GetToken", json_encode($input));
            $output = new stdClass();
            $output->status = "ok";
            log_message("info", "Returning from SubmitMORequest");
            $this->output->set_content_type('application/json')->set_output(json_encode($output));
	}
}


