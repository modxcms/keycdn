<?php
$output = '';
switch ($options[xPDOTransport::PACKAGE_ACTION]) {
    case xPDOTransport::ACTION_INSTALL:
        $output = '
            <label for="kcdn_alias">Alias:</label>
            <input type="text" name="alias" id="kcdn_alias" width="300" value="" />
            <br /><br />

            <label for="kcdn_api_key">API Key:</label>
            <input type="text" name="api_key" id="kcdn_api_key" width="300" value="" />
            <br /><br />

            <label for="kcdn_zone_id">Zone ID:</label>
            <input type="text" name="zone_id" id="kcdn_zone_id" width="300" value="" />
            <br /><br />

            <label for="kcdn_default_cdn_url">Default CDN URL:</label>
            <input type="text" name="default_cdn_url" id="kcdn_default_cdn_url" width="300" value="" />
            <br /><br />

            <label for="kcdn_url_preview_param">URL Preview Parameter:</label>
            <input type="text" name="url_preview_param" id="kcdn_url_preview_param" width="300" value="guid" />
            <br /><br />

            <label for="kcdn_enabled">Enable KeyCDN:</label>
            <input type="radio" name="enabled" value="1" checked="checked">Yes<br />
            <input type="radio" name="enabled" value="0">No

            <label for="kcdn_enabled">Install Default Rules:</label>
            <input type="radio" name="rules" value="1" checked="checked">Yes<br />
            <input type="radio" name="rules" value="0">No

        ';

        break;
    case xPDOTransport::ACTION_UPGRADE:
        break;
    case xPDOTransport::ACTION_UNINSTALL:
        break;
}

return $output;