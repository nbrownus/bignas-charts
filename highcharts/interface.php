<?
function eth0() {
    global $rrdLocation, $startTime;

    $graph = getDefaultGraph();
    $graph['title']['text'] = 'eth0 octets';
    $graph['yAxis']['title']['text'] = 'octets';
    $graph['yAxis']['min'] = 0;

    $info = getInfo($startTime, time(), $rrdLocation . '/interface/if_octets-eth0.rrd');

    $graph['series'][0] = array(
        'name' => 'received',
        'data' => array(),
        'pointInterval' => ($info['step'] * 1000),
        'pointStart' => $info['start'] * 1000,
    );

    $graph['series'][1] = array(
        'name' => 'transmitted',
        'data' => array(),
        'pointInterval' => ($info['step'] * 1000),
        'pointStart' => $info['start'] * 1000,
    );

    foreach ($info['data']['rx'] as $speed) {
        $graph['series'][0]['data'][] = $speed;
    }

    foreach ($info['data']['tx'] as $speed) {
        $graph['series'][1]['data'][] = $speed;
    }

    return $graph;
}

return eth0();
