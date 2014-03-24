<?
function cpu_idle () {
    global $rrdLocation, $startTime;

    $cpu_final = getDefaultGraph();
    $cpu_final['title']['text'] = 'Idle CPU';
    $cpu_final['yAxis']['title']['text'] = '% idle';
    $cpu_final['yAxis']['max'] = 100;
    $cpu_final['yAxis']['min'] = 0;

    $cpu0 = getInfo($startTime, time(), $rrdLocation . '/cpu-0/cpu-idle.rrd');
    $cpu1 = getInfo($startTime, time(), $rrdLocation . '/cpu-1/cpu-idle.rrd');

    $cpu_final['series'] = array(
        array(
            'name' => 'cpu-0',
            'data' => array(),
            'pointInterval' => $cpu0['step'] * 1000,
            'pointStart' => ($cpu0['start'] - (60 * 60 * 8)) * 1000,
        ),
        array(
            'name' => 'cpu-1',
            'data' => array(),
            'pointInterval' => $cpu1['step'] * 1000,
            'pointStart' => ($cpu1['start'] - (60 * 60 * 8)) * 1000,
        )
    );

    foreach ($cpu0['data']['value'] as $idle) {
        $cpu_final['series'][0]['data'][] = $idle;
    }

    foreach ($cpu1['data']['value'] as $idle) {
        $cpu_final['series'][1]['data'][] = $idle;
    }

    return $cpu_final;
}

return cpu_idle();
