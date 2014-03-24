<?
function mb_temps() {
    global $rrdLocation, $startTime;

    $mb_temps = getDefaultGraph();
    $mb_temps['title']['text'] = 'MB Temps';
    $mb_temps['yAxis']['title']['text'] = '°C';

    $temp_rrds = array(
        array('name' => 'ambient', 'loc' => $rrdLocation . '/sensors-it8718-isa-0290/temperature-temp1.rrd'),
        array('name' => 'core-1', 'loc' => $rrdLocation . '/sensors-coretemp-isa-0000/temperature-temp2.rrd'),
        array('name' => 'core-2', 'loc' => $rrdLocation . '/sensors-coretemp-isa-0000/temperature-temp3.rrd'),
    );

    foreach ($temp_rrds as $index => $rrd) {
        $info = getInfo($startTime, time(), $rrd['loc']);
        $mb_temps['series'][$index] = array(
            'name' => $rrd['name'],
            'data' => array(),
            'pointInterval' => ($info['step'] * 1000),
            'pointStart' => $info['start'] * 1000,
        );

        foreach ($info['data']['value'] as $speed) {
            $mb_temps['series'][$index]['data'][] = $speed;
        }
    }

    return $mb_temps;
}

return mb_temps();
