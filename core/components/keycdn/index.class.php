<?php

require_once dirname(__FILE__) . '/model/keycdn/modxkeycdn.class.php';

/**
 * The main Manager Controller.
 * In this class, we define stuff we want on all of our controllers.
 */
abstract class KeyCDNManagerController extends modExtraManagerController {
    /** @var KeyCDN $kcdn */
    public $kcdn = null;

    /**
     * Initializes the main manager controller. In this case we set up the
     * KeyCDN class and add the required javascript on all controllers.
     */
    public function initialize() {
        /* Instantiate the class in the controller */
        $this->kcdn = new modXKeyCDN($this->modx);

        /* Add the main javascript class and our configuration */
        $this->addJavascript($this->kcdn->config['jsUrl'].'mgr/keycdn.class.js');
        $this->addCss($this->kcdn->config['cssUrl'].'mgr/keycdn.css');
        $this->addHtml('<script type="text/javascript">
        Ext.onReady(function() {
            KeyCDN.config = '.$this->modx->toJSON($this->kcdn->config).';
        });
        </script>');
    }

    /**
     * Defines the lexicon topics to load in our controller.
     * @return array
     */
    public function getLanguageTopics() {
        return array('keycdn:default');
    }

    /**
     * We can use this to check if the user has permission to see this
     * controller. We'll apply this in the admin section.
     * @return bool
     */
    public function checkPermissions() {
        return true;
    }
}

/**
 * The Index Manager Controller is the default one that gets called when no
 * action is present. It's most commonly used to define the default controller
 * which then hands over processing to the other controller ("home").
 */
class IndexManagerController extends KeyCDNManagerController {
    /**
     * Defines the name or path to the default controller to load.
     * @return string
     */
    public static function getDefaultController() {
        return 'home';
    }
}
