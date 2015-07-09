<?php
/**
 * Purge Files from KeyCDN
 */
class filesPurgeProcessor extends modProcessor {
    public $languageTopics = array('keycdn:default');

    public function process() {
        $response = null;
        if ($this->modx->kcdn->authenticate()) {
            if ($this->getProperty('purge_all') == 'true') {
                $response = $this->modx->kcdn->purge();
            } else {
                $files = explode("\n", $this->getProperty('purge_files'));
                foreach ($files as $k => $v) {
                    if (empty($v)) unset($files[$k]);
                }
                if (!empty($files)) {
                    $response = $this->modx->kcdn->purgeFiles($files);
                }
            }
        } else {
            return $this->modx->error->failure($this->modx->lexicon('kcdn.purge_request_no_auth'));
        }

        if ($response == null) {
            return $this->modx->error->failure($this->modx->lexicon('kcdn.purge_nothing_found'));
        } else {
            $response = $this->modx->fromJSON($response);
            if ($response['status'] !== 'success') {
                return $this->modx->error->failure($response['status']. ': ' .$response['description']);
            }
            return $this->modx->error->success($this->modx->lexicon('kcdn.purge_request_sent'));
        }
    }
}
return 'filesPurgeProcessor';