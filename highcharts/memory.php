<?
function memory_all () {
    global $rrdLocation, $startTime;

    $memory_final = getDefaultGraph();
    $memory_final['title']['text'] = 'Memory';
    $memory_final['yAxis']['title']['text'] = 'bytes';

    $buffered = getInfo($startTime, time(), $rrdLocation . '/memory/memory-buffered.rrd');
    $cached = getInfo($startTime, time(), $rrdLocation . '/memory/memory-cached.rrd');
    $free = getInfo($startTime, time(), $rrdLocation . '/memory/memory-free.rrd');
    $used = getInfo($startTime, time(), $rrdLocation . '/memory/memory-used.rrd');

    $memory_final['series'] = array(
        array(
            'name' => 'buffered',
            'data' => array(),
            'pointInterval' => $buffered['step'] * 1000,
            'pointStart' => ($buffered['start'] - (60 * 60 * 8)) * 1000,
        ),
        array(
            'name' => 'cached',
            'data' => array(),
            'pointInterval' => $cached['step'] * 1000,
            'pointStart' => ($cached['start'] - (60 * 60 * 8)) * 1000,
        ),
        array(
            'name' => 'free',
            'data' => array(),
            'pointInterval' => $free['step'] * 1000,
            'pointStart' => ($free['start'] - (60 * 60 * 8)) * 1000,
        ),
        array(
            'name' => 'used',
            'data' => array(),
            'pointInterval' => $used['step'] * 1000,
            'pointStart' => ($used['start'] - (60 * 60 * 8)) * 1000,
        )
    );

    foreach ($buffered['data']['value'] as $data) {
        $memory_final['series'][0]['data'][] = $data;
    }

    foreach ($cached['data']['value'] as $data) {
        $memory_final['series'][1]['data'][] = $data;
    }

    foreach ($free['data']['value'] as $data) {
        $memory_final['series'][2]['data'][] = $data;
    }

    foreach ($used['data']['value'] as $data) {
        $memory_final['series'][3]['data'][] = $data;
    }

    return $memory_final;
}

return memory_all();
