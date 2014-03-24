<?
function fan_speeds () {
    global $rrdLocation, $startTime;

    $fan_speeds = getDefaultGraph();
    $fan_speeds['title']['text'] = 'Fan Speeds';
    $fan_speeds['yAxis']['title']['text'] = 'rpm';

    $fan_rrds = array(
        array('name' => 'CPU fan', 'loc' => $rrdLocation . '/sensors-it8718-isa-0290/fanspeed-fan1.rrd'),
        array('name' => 'Case 1', 'loc' => $rrdLocation . '/sensors-it8718-isa-0290/fanspeed-fan3.rrd'),
        array('name' => 'Case 2', 'loc' => $rrdLocation . '/sensors-it8718-isa-0290/fanspeed-fan4.rrd'),
    );

    foreach ($fan_rrds as $index => $rrd) {
        $info = getInfo($startTime, time(), $rrd['loc']);
        $fan_speeds['series'][$index] = array(
            'name' => $rrd['name'],
            'data' => array(),
            'pointInterval' => ($info['step'] * 1000),
            'pointStart' => $info['start'] * 1000,
        );

        foreach ($info['data']['value'] as $speed) {
            $fan_speeds['series'][$index]['data'][] = $speed;
        }
    }

    return $fan_speeds;
}


return fan_speeds();
