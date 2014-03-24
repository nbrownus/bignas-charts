<?
function hdd_temps() {
    global $rrdLocation, $startTime;
    $hdd_temps = getDefaultGraph();
    $hdd_temps['title']['text'] = 'HDD Temps';
    $hdd_temps['yAxis']['title']['text'] = '°C';

    exec('find ' . $rrdLocation . '/hddtemp/ -name "temperature-*-*.rrd"', $hdd_rrds);

    foreach ($hdd_rrds as $index => $rrd) {
        $info = getInfo($startTime, time(), $rrd);
        $hdd_temps['series'][$index] = array(
            'name' => 'hdd ' . substr(basename($rrd, '.rrd'), 12),
            'data' => array(),
            'pointInterval' => ($info['step'] * 1000),
            'pointStart' => $info['start'] * 1000,
        );

        foreach ($info['data']['value'] as $temp) {
            $hdd_temps['series'][$index]['data'][] = $temp;
        }
    }

    return $hdd_temps;
}

return hdd_temps();
