<?
function df_stats () {
    global $rrdLocation, $startTime;

    $df_final = getDefaultGraph();
    $df_final['title']['text'] = 'Disk Utilization';
    $df_final['yAxis']['title']['text'] = '% used';
    $df_final['yAxis']['max'] = 100;
    $df_final['yAxis']['min'] = 0;

    $boot = getInfo($startTime, time(), $rrdLocation . '/df/df-boot.rrd');
    $root = getInfo($startTime, time(), $rrdLocation . '/df/df-root.rrd');
    $main = getInfo($startTime, time(), $rrdLocation . '/df/df-storage-raid6-main.rrd');
    $backup = getInfo($startTime, time(), $rrdLocation . '/df/df-storage-raid6-backup.rrd');
    $time_machine = getInfo($startTime, time(), $rrdLocation . '/df/df-storage-raid6-time_machine.rrd');

    $df_final['series'] = array(
        array(
            'name' => 'boot',
            'data' => array(),
            'pointInterval' => $boot['step'] * 1000,
            'pointStart' => $boot['start'] * 1000,
        ),
        array(
            'name' => 'root',
            'data' => array(),
            'pointInterval' => $root['step'] * 1000,
            'pointStart' => $root['start'] * 1000,
        ),
        array(
            'name' => 'main',
            'data' => array(),
            'pointInterval' => $main['step'] * 1000,
            'pointStart' => $main['start'] * 1000,
        ),
        array(
            'name' => 'backup',
            'data' => array(),
            'pointInterval' => $backup['step'] * 1000,
            'pointStart' => $backup['start'] * 1000,
        ),
        array(
            'name' => 'time_machine',
            'data' => array(),
            'pointInterval' => $time_machine['step'] * 1000,
            'pointStart' => $time_machine['start'] * 1000,
        )
    );

    foreach ($boot['data']['used'] as $time => $value) {
        $df_final['series'][0]['data'][] = ($boot['data']['used'][$time] / ($boot['data']['used'][$time] + $boot['data']['free'][$time])) * 100;
    }

    foreach ($root['data']['used'] as $time => $value) {
        $df_final['series'][1]['data'][] = ($root['data']['used'][$time] / ($root['data']['used'][$time] + $root['data']['free'][$time])) * 100;
    }

    foreach ($main['data']['used'] as $time => $value) {
        $df_final['series'][2]['data'][] = ($main['data']['used'][$time] / ($main['data']['used'][$time] + $main['data']['free'][$time])) * 100;
    }

    foreach ($backup['data']['used'] as $time => $value) {
        $df_final['series'][3]['data'][] = ($backup['data']['used'][$time] / ($backup['data']['used'][$time] + $backup['data']['free'][$time])) * 100;
    }

    foreach ($time_machine['data']['used'] as $time => $value) {
        $df_final['series'][4]['data'][] = ($time_machine['data']['used'][$time] / ($time_machine['data']['used'][$time] + $time_machine['data']['free'][$time])) * 100;
    }

    return $df_final;
}

return df_stats();
