<?php
$eventName = $modx->event->name;
switch($eventName) {
    case 'OnWebPagePrerender':
        $path = $modx->getOption('kcdn.core_path', null, $modx->getOption('core_path') . 'components/keycdn/');
        $keycdn = $modx->getService('modxkeycdn','modXKeyCDN', $path.'/model/keycdn/');

        if ($keycdn->isDisabled(true)) {
            break;
        }

        $c = $modx->newQuery('kcdnRule');
        $c->where(array(
            'content_type' => $modx->resource->get('content_type'),
            'disabled' => false,
            array(
                array(
                    'all_contexts' => true
                ),
                array(
                    'OR:context:=' => $modx->context->get('key')
                )
            )
        ));
        $c->sortby('sortorder', 'ASC');

        $rules = $modx->getIterator('kcdnRule', $c);
        foreach ($rules as $rule) {
            $callback = function($matches) use ($rule) {
                $output = $rule->get('output');
                foreach($matches as $k => $v) {
                    if ($k == 0) continue;
                    $output = str_replace('{match'.$k.'}', $v, $output);
                }
                $output = str_replace('{cdn_url}', $rule->getCdnUrl(), $output);
                return $output;
            };

            $modx->resource->_output = preg_replace_callback($rule->getRegex(), $callback, $modx->resource->_output);
        }
        break;
    default:
        break;
}