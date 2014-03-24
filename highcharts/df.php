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
            'pointStart' => ($boot['start'] - (60 * 60 * 8)) * 1000,
        ),
        array(
            'name' => 'root',
            'data' => array(),
            'pointInterval' => $root['step'] * 1000,
            'pointStart' => ($root['start'] - (60 * 60 * 8)) * 1000,
        ),
        array(
            'name' => 'main',
            'data' => array(),
            'pointInterval' => $main['step'] * 1000,
            'pointStart' => ($main['start'] - (60 * 60 * 8)) * 1000,
        ),
        array(
            'name' => 'backup',
            'data' => array(),
            'pointInterval' => $backup['step'] * 1000,
            'pointStart' => ($backup['start'] - (60 * 60 * 8)) * 1000,
        ),
        array(
            'name' => 'time_machine',
            'data' => array(),
            'pointInterval' => $time_machine['step'] * 1000,
            'pointStart' => ($time_machine['start'] - (60 * 60 * 8)) * 1000,
        )
    );

    foreach ($boot['data']['value'] as $data) {
        $df_final['series'][0]['data'][] = ($data['used'] / $data['used'] + $data['free']) * 100;
    }

    foreach ($root['data']['value'] as $data) {
        $df_final['series'][0]['data'][] = ($data['used'] / $data['used'] + $data['free']) * 100;
    }

    foreach ($main['data']['value'] as $data) {
        $df_final['series'][0]['data'][] = ($data['used'] / $data['used'] + $data['free']) * 100;
    }

    foreach ($backup['data']['value'] as $data) {
        $df_final['series'][0]['data'][] = ($data['used'] / $data['used'] + $data['free']) * 100;
    }

    foreach ($time_machine['data']['value'] as $data) {
        $df_final['series'][0]['data'][] = ($data['used'] / $data['used'] + $data['free']) * 100;
    }

    return $df_final;
}

return df_stats();
