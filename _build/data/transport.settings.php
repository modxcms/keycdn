<?php

$s = array(
    'api_key' => '',
    'zone_id' => '',
    'default_cdn_url' => '',
    'url_preview_param' => 'guid',
    'enabled' => true,
    'resource_inclusion_tv' => '',
    'purge_on_clear_cache' => true
);

$settings = array();

foreach ($s as $key => $value) {
    if (is_string($value) || is_int($value)) { $type = 'textfield'; }
    elseif (is_bool($value)) { $type = 'combo-boolean'; }
    else { $type = 'textfield'; }

    $parts = explode('.',$key);
    if (count($parts) == 1) { $area = 'Default'; }
    else { $area = $parts[0]; }
    
    $settings['kcdn.'.$key] = $modx->newObject('modSystemSetting');
    $settings['kcdn.'.$key]->set('key', 'kcdn.'.$key);
    $settings['kcdn.'.$key]->fromArray(array(
        'value' => $value,
        'xtype' => $type,
        'namespace' => 'keycdn',
        'area' => $area
    ));
}

return $settings;


