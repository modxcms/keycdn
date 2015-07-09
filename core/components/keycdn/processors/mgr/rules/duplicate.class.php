<?php
/**
 * Duplicates a kcdnRule object
 */
class kcdnRuleDuplicateProcessor extends modObjectDuplicateProcessor {
    public $classKey = 'kcdnRule';
    public $languageTopics = array('keycdn:default');

    public function getNewName() {
        $newName = $this->modx->lexicon('kcdn.duplicate_of') . $this->object->get('name');
        return $newName;
    }

    /**
     * Before saving, we disable the duplicated rule.
     * @return bool
     */
    public function beforeSave() {
        $this->newObject->set('disabled', true);
        return parent::beforeSave();
    }
}
return 'kcdnRuleDuplicateProcessor';
