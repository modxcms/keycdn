<?php
/**
 * Gets a list of kcdnRules objects.
 */
class kcdnRulesGetListProcessor extends modObjectGetListProcessor {
    public $classKey = 'kcdnRule';
    public $languageTopics = array('keycdn:default');
    public $defaultSortField = 'sortorder';
    public $defaultSortDirection = 'ASC';

    /**
     * @param xPDOQuery $c
     * @return xPDOQuery
     */
    public function prepareQueryBeforeCount(xPDOQuery $c) {
        $c->leftJoin('modContentType','ContentType');
        $c->select($this->modx->getSelectColumns('kcdnRule', 'kcdnRule'));
        $c->select($this->modx->getSelectColumns('modContentType', 'ContentType', 'content_type_', array('name')));

        return $c;
    }

    /**
     * @param xPDOQuery $c
     * @return xPDOQuery
     */
    public function prepareQueryAfterCount(xPDOQuery $c) {
        $c->sortby('content_type', 'ASC');
        $c->sortby('context', 'ASC');
        $c->sortby('sortorder', 'ASC');

        return $c;
    }

    /**
     * Transform the xPDOObject derivative to an array;
     * @param xPDOObject $object
     * @return array
     */
    public function prepareRow(xPDOObject $object) {
        $row = $object->toArray('', false, true);
        return $row;
    }
}
return 'kcdnRulesGetListProcessor';
