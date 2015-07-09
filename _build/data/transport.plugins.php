<?php
$plugins = array();

/* create the plugin object */
$plugins[0] = $modx->newObject('modPlugin');
$plugins[0]->set('id',1);
$plugins[0]->set('name','KeyCDN Manager');
$plugins[0]->set('description','Provides manager functionality for resources if resources are being cached to KeyCDN.');
$plugins[0]->set('plugincode', getSnippetContent($sources['plugins'] . 'keycdn.plugin.php'));
$plugins[0]->set('category', 0);
switch ($options[xPDOTransport::PACKAGE_ACTION]) {
    case xPDOTransport::ACTION_INSTALL:
        $plugins[0]->set('disabled', 1);
        break;
    default:
        break;
}

$events = include $sources['events'].'events.keycdn.php';
if (is_array($events) && !empty($events)) {
    $plugins[0]->addMany($events);
    $modx->log(xPDO::LOG_LEVEL_INFO,'Packaged in '.count($events).' Plugin Events for KeyCDN.'); flush();
} else {
    $modx->log(xPDO::LOG_LEVEL_ERROR,'Could not find plugin events for KeyCDN!');
}
unset($events);

/* create the plugin object */
$plugins[1] = $modx->newObject('modPlugin');
$plugins[1]->set('id',1);
$plugins[1]->set('name','KeyCDN Linker');
$plugins[1]->set('description','Rewrites frontend links based on KeyCDN Rules specified in the KeyCDN component.');
$plugins[1]->set('plugincode', getSnippetContent($sources['plugins'] . 'keycdnlinker.plugin.php'));
$plugins[1]->set('category', 0);

$events = include $sources['events'].'events.keycdnlinker.php';
if (is_array($events) && !empty($events)) {
    $plugins[1]->addMany($events);
    $modx->log(xPDO::LOG_LEVEL_INFO,'Packaged in '.count($events).' Plugin Events for KeyCDN Linker.'); flush();
} else {
    $modx->log(xPDO::LOG_LEVEL_ERROR,'Could not find plugin events for KeyCDN Linker!');
}
unset($events);

/* create the plugin object */
$plugins[2] = $modx->newObject('modPlugin');
$plugins[2]->set('id',1);
$plugins[2]->set('name','KeyCDN Purge on Clear Cache');
$plugins[2]->set('description','Purges the KeyCDN Cache when selecting Clear Cache in the MODX Manager.');
$plugins[2]->set('plugincode', getSnippetContent($sources['plugins'] . 'keycdnpurgecache.plugin.php'));
$plugins[2]->set('category', 0);

$events = include $sources['events'].'events.keycdnpurgecache.php';
if (is_array($events) && !empty($events)) {
    $plugins[2]->addMany($events);
    $modx->log(xPDO::LOG_LEVEL_INFO,'Packaged in '.count($events).' Plugin Events for KeyCDN Purge.'); flush();
} else {
    $modx->log(xPDO::LOG_LEVEL_ERROR,'Could not find plugin events for KeyCDN Purge!');
}
unset($events);

return $plugins;
