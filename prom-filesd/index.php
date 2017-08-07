<?php
function getname($ip){
   $url = $ip.":9100/metrics";
   $ch = curl_init($url);
   curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
   curl_setopt($ch, CURLOPT_TIMEOUT,10);
   $output = curl_exec($ch);
   curl_close($ch);
   return $output;
}

function addport($ips,$port){
    foreach ($ips as &$ip)
        $ip = $ip.":".$port;
    return $ips;
}

$dockerhosts=array();
$hosts = dns_get_record("tasks.node-exporter", DNS_A);
foreach($hosts as $host){
    preg_match('/host{host="(.*)"}(.*)/', getname($host['ip']), $node);
    //$dockerhosts[] = $node[1];
    //$dockerhosts[$node[1]] = dns_get_record($node[1], DNS_A);
    $hostip = dns_get_record($node[1], DNS_A);
    //$dockerhosts[$node[1]] = $hostip[0]['ip'];
    $dockerhosts[] = $hostip[0]['ip'];
}
$cadvisor = addport($dockerhosts, 18080);
$nodeexporter = addport($dockerhosts, 9100);
#$dockerexporter = addport($dockerhosts, 4999);

$filesd = array();
$filesd[] = array('targets' => $cadvisor, 'labels' => array('env' => 'prod', 'job' => 'cadvisor'));
$filesd[] = array('targets' => $nodeexporter, 'labels' => array('env' => 'prod', 'job' => 'node-exporter'));
#$filesd[] = array('targets' => $dockerexporter, 'labels' => array('env' => 'prod', 'job' => 'docker-exporter'));

header('Content-Type: application/json;charset=utf-8');
echo json_encode($filesd);
?>