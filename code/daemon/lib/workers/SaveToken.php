<?php

require_once 'lib/utils/static.php';

class SaveToken {
    public function run($job, &$log) {
        $sql = $job->workload();
        echo "\nProcessing SQL: $sql\n";
        connection();
        save($sql);
        disconnect();
        $log[] = "Success";
        return 1;
    }
}

?>