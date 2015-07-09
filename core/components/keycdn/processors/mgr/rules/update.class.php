<?php
/**
 * Updates a kcdnRule object
 */
class kcdnRuleUpdateProcessor extends modObjectUpdateProcessor {
    public $classKey = 'kcdnRule';
    public $languageTopics = array('keycdn:default');

    /**
     * Before setting, we check if the name is filled and/or already exists. Also checkboxes.
     * @return bool
     */
    public function beforeSet() {
        $key = $this->getProperty('name');
        if (empty($key)) {
            $this->addFieldError('name',$this->modx->lexicon('kcdn.error.name_not_set'));
        }
        $this->setCheckbox('disabled', true);
        $this->setCheckbox('all_contexts', true);
        if ($this->getProperty('all_contexts')) {
            $this->setProperty('context', '');
        }
        return parent::beforeSet();
    }
}
return 'kcdnRuleUpdateProcessor';
