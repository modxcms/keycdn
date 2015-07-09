<?php
/* @var modX $modx */

if ($object->xpdo) {
    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_UPGRADE:
        case xPDOTransport::ACTION_INSTALL:
            $modx =& $object->xpdo;

            $modelPath = $modx->getOption('kcdn.core_path',null,$modx->getOption('core_path').'components/keycdn/').'model/';
            $modx->addPackage('keycdn',$modelPath, '');
            $manager = $modx->getManager();
            $loglevel = $modx->setLogLevel(modX::LOG_LEVEL_ERROR);
            
            $objects = array('kcdnRule');
            foreach ($objects as $obj) {
                $manager->createObjectContainer($obj);
            }

            $modx->setLogLevel($loglevel);
        break;
    }

}
return true;

