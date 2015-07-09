<?php
/**
 * Gets a list of CDN URLs from KeyCDN.
 */
class comboCDNGetListProcessor extends modProcessor {
    public $languageTopics = array('keycdn:default');

    public function process() {
        $list = array();

        $defaultCDN = $this->modx->getOption('kcdn.default_cdn_url', null, '');
        if (!empty($defaultCDN)) {
            $list[]['cdn_url'] = $defaultCDN;
        }

        if($this->modx->kcdn->authenticate()) {
            $zone = $this->modx->getOption('kcdn.zone_id', null, '');
            $response = $this->modx->kcdn->api->get('zonealiases.json');
            $domains = $this->modx->fromJSON($response);

            foreach ($domains['data']['zonealiases'] as $domain) {
                if ($domain['zone_id'] == $zone) {
                    $list[]['cdn_url'] = $domain['name'];
                }
            }
        }
        return $this->outputArray($list, count($list));
    }
}
return 'comboCDNGetListProcessor';
