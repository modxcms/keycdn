<?php
$event = $modx->event->name;
switch ($event) {
    case 'OnSiteRefresh':
        $path = $modx->getOption('kcdn.core_path', null, $modx->getOption('core_path') . 'components/keycdn/');
        $keycdn = $modx->getService('modxkeycdn','modXKeyCDN', $path.'model/keycdn/');

        if ($keycdn->isDisabled()) {
            break;
        }

        $purgeCache = $modx->getOption('kcdn.purge_on_clear_cache', null, true);
        if ($purgeCache == false) {
            break;
        }

        if ($keycdn->authenticate()) {
            $response = $keycdn->purge();
            $response = $modx->fromJSON($response);
            if ($response['status'] !== 'success') {
                $modx->log(modX::LOG_LEVEL_ERROR, $response['status']. ': ' .$response['description']);
            }
            $modx->log(modX::LOG_LEVEL_INFO, $modx->lexicon('kcdn.purge_request_sent'));
        } else {
            $modx->log(modX::LOG_LEVEL_ERROR, $modx->lexicon('kcdn.purge_request_no_auth'));
        }
        break;
    default:
        break;
}