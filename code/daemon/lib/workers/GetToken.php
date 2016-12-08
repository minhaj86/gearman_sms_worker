<?php

require_once 'lib/utils/static.php';

class GetToken {
    public function run($job, &$log) {
        $workload = $job->workload();
        $token = get_auth_token($workload);
        $params = json_decode($workload);
        $params->token = $token;
        echo "Authorized Token : " . print_r($params,1);
        // Send entry to sql worker
        $this->transfer_work_to_db_worker("insert into mo values (NULL, '".$params->msisdn."', '".$params->operatorid."', '".$params->shortcodeid."', '".$params->text."', '".$params->token."', now());");

        $log[] = "Success";

        return 1;
    }
    private function transfer_work_to_db_worker($sql) {
        echo "\nExecuting SQL: $sql\n";
        $client = new GearmanClient();
        $client->addServer();
        $result = $client->doBackground("SaveToken", $sql);
    }


}

?>