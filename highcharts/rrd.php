<?
header('Content-type: application/json');

$rrdLocation = '/var/lib/collectd/rrd/big-nas';

function getDefaultGraph () {
    return array(
        'chart' => array(
            'type' => 'line',
        ),
        'title' => array(
            'text' => 'CHANGE ME'
        ),
        'tooltip' => array(
            'xDateFormat' => '%l:%M:%S %p',
            'shared' => true
        ),
        'xAxis' => array(
            'type' => 'datetime',
        ),
        'yAxis' => array(
            'title' => array('text' => 'CHANGE ME!')
        ),
        'credits' => array('enabled' => false),
        'plotOptions' => array(
            'line' => array(
                'marker' => array(
                    'enabled' => false,
                    'states' => array(
                        'hover' => array(
                            'enabled' => true,
                            'radius' => 5
                        )
                    )
                )
            ),
            'series' => array('lineWidth' => 1, 'shadow' => false)
        ),
        'series' => array()
    );
}

$startTime = floor($_REQUEST['start'] / 1000);

function getInfo ($start, $end, $path) {
    $info = rrd_info($path);

    $options = array(
        '--start', $start,
        '--end', (floor(min($end, $info['last_update']) / $info['step']) * $info['step'] - 1),
        'AVERAGE'
    );

    return rrd_fetch($path, $options);
}

$graphs = array(
    'cpu-idle' => include('cpu.php'),
    'hdd-temp' => include('hdd_temp.php'),
    'fan-speeds' => include('fan_speed.php'),
    'mb-temps' => include('mb_temps.php'),
    'interface' => include('interface.php'),
    'memory' => include('memory.php'),
    'df' => include('df.php')
);

echo json_encode($graphs);
