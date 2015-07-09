<?php
class modXKeyCDN {
    /**
     * @var modX|null $modx
     */
    public $modx = null;
    /**
     * @var NetDNA|null $api
     */
    public $api = null;
    /**
     * @var array
     */
    public $config = array();
    /**
     * @var bool
     */
    public $debug = false;
    /**
     * @var array
     */
    public $cacheOptions = array(
        xPDO::OPT_CACHE_KEY => 'keycdn',
    );


    /**
     * @param \modX $modx
     * @param array $config
     */
    function __construct(modX &$modx,array $config = array()) {
        $this->modx =& $modx;

        $corePath = $this->modx->getOption('kcdn.core_path',null,$this->modx->getOption('core_path').'components/keycdn/');
        $assetsUrl = $this->modx->getOption('kcdn.assets_url',null,$this->modx->getOption('assets_url').'components/keycdn/');
        $assetsPath = $this->modx->getOption('kcdn.assets_path',null,$this->modx->getOption('assets_path').'components/keycdn/');
        $this->config = array_merge(array(
            'basePath' => $corePath,
            'corePath' => $corePath,
            'modelPath' => $corePath.'model/',
            'processorsPath' => $corePath.'processors/',
            'elementsPath' => $corePath.'elements/',
            'templatesPath' => $corePath.'templates/',
            'assetsPath' => $assetsPath,
            'jsUrl' => $assetsUrl.'js/',
            'cssUrl' => $assetsUrl.'css/',
            'assetsUrl' => $assetsUrl,
            'connectorUrl' => $assetsUrl.'connector.php',
        ),$config);

        $modelPath = $this->config['modelPath'];
        $this->modx->addPackage('keycdn',$modelPath, '');
        $this->modx->lexicon->load('keycdn:default');
        $this->debug = (bool)$this->modx->getOption('kcdn.debug',null,false);
        $this->autoload();
    }

    public function autoload() {
        require_once $this->config['corePath'].'model/vendor/autoload.php';
    }

    public function authenticate() {
        $apiKey = $this->modx->getOption('kcdn.api_key', null, '');
        if (!empty($apiKey)) {
            $this->api = new KeyCDN($apiKey);
            return true;
        }
        return false;
    }

    public function isDisabled($checkTV = false) {
        if ($this->modx->getOption('kcdn.enabled', null, false) == false) {
            return true;
        }
        if ($checkTV) {
            $tvName = $this->modx->getOption('kcdn.resource_inclusion_tv', null, '');
            if (!empty($tvName) && $this->modx->resource !== null) {
                $include = $this->modx->resource->getTVValue($tvName);
                if (!$include) {
                    return true;
                }
            }
        }
        return false;
    }

    public function purge($params = array()) {
        $zone = $this->modx->getOption('kcdn.zone_id', null, '');
        if ($this->api == null) {
            $this->authenticate();
        }
        if (!empty($params)) {
            return $this->api->delete('zones/purgeurl/' . $zone . '.json', $params);
        } else {
            return $this->api->get('zones/purge/' . $zone . '.json');
        }
    }

    public function purgeFile($file) {
        $params = array(
            'path' => $file
        );
        return $this->purge($params);
    }

    public function purgeFiles($files) {
        $params = array(
            'urls' => $files
        );
        return $this->purge($params);
    }
}

