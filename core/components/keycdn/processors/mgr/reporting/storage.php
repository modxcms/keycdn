<?php
$hits = array();
$stats = array();
$data = $modx->cacheManager->get('stats.daily', $modx->kcdn->cacheOptions);
if (!$data) {
    if ($modx->kcdn->authenticate()) {
        $zone = $modx->getOption('kcdn.zone_id', null, '');
        $start = strtotime('-30 days');
        $end = time();
        $stats = $modx->kcdn->api->get('reports/storage.json', array(
            'zone_id' => $zone,
            'start' => $start,
            'end' =>  $end
        ));
        $data = $modx->fromJSON($stats);
        if (is_array($data)) {
            //$modx->cacheManager->set('stats.daily', $data, 300, $modx->kcdn->cacheOptions);
        }
    }
}

foreach ($data['data']['stats'] as $obj) {
    $hits[] = array(
        'c' => array(
            array(
                'v' => date('M j', strtotime($obj['timestamp']))
            ),
            array (
                'v' => round(($obj['amount']/1024)/1024, 2)
            )
        )
    );
}
$stats = array(
    'cols' => array(
        array(
            'id' => '',
            'label' => $modx->lexicon('kcdn.reporting_time'),
            'pattern' => '',
            'type' => 'string'
        ),
        array(
            'id' => '',
            'label' => $modx->lexicon('kcdn.reporting_amount'),
            'pattern' => '',
            'type' => 'number'
        )
    ),
    'rows' => $hits
);

return $modx->toJSON($stats);