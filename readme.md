# MODX KeyCDN Toolkit

## Introduction
The MODX KeyCDN Toolkit provides the necessary elements to dynamically integrate KeyCDN with MODX. There are five elements to the toolkit:

* __Rules Manager__: The Rules Manager allows for frontend rules to be specified via a regular expression syntax. These rules will allow the targetted link structures (such as src or href attributes) to be rewritten to point to your CDN URL.
* __KeyCDN Linker Plugin__: The KeyCDN Linker plugin accesses the rules specified in the Rules Manager and dynamically rewrites the link structures on the frontend. See the Selective Caching section below.
* __KeyCDN Purge on Clear Cache Plugin__: The Purge Cache plugin will send a 'purge all' request to KeyCDN when using the Clear Cache menu option in the MODX Manager. This plugin can be enabled or disabled via the _kcdn.purge_on_clear_cache_ system setting.
* __KeyCDN Manager Plugin__: The KeyCDN Manager plugin provides advanced manager integration. It is only applicable if you are utilising the full-page caching implementation (covered below in the Full-Page Caching section). By default, this is disabled on install due to it's specific usage requirements.
* __Purge Tool__: A simple form-based Purge tool allowing either a full purge of the KeyCDN pull zone or selective purging of individual files.

## Pre-Requisites
The following pre-requisites are required prior to installation:

* You have signed up for KeyCDN and configured your pull zone
	* Signup [here](https://www.keycdn.com)
    * Configure a pull zone: https://www.keycdn.com/support/create-a-pull-zone/
    * Implement the SEO options (particularly the robots.txt) on your pull zone described [here](https://www.keycdn.com/blog/best-seo-cdn/): https://www.keycdn.com/support/pull-zone-settings/
* You have created an API Key for your KeyCDN account. This is an option on the KeyCDN Control Panel.
* PHP 5.3 or above

## Installation
On installation of the KeyCDN component, have the following pieces of information available to expedite the setup:

* Your Pull Zone ID
* Your API Key
* Your default CDN URL (the KeyCDN generated CDN URL, xxx.kxcdn.com)

__Note: It is recommended that you initially select the _disabled_ option on install otherwise the KeyCDN Linker plugin will be immediately active which may not be desired. Once the component is installed, you can check settings, make any configuration or rule changes and then enable the KeyCDN integration.__ 

## Difference between CDN Strategies
### Selective CDN Caching

Selective caching is where you specifically target certain frontend static assets normally served from your site's domain to be served from the CDN domain instead. The MODX KeyCDN Toolkit supports this approach via a combination of the Rules Manager and the KeyCDN Linker plugin.

With the Rules Manager, you can either use the default rules (which should satisfy most use cases) or you can be more specific with custom rules, for example, only CDN cache assets in a certain folder or with a certain extension. These rules are applied against content types and can be applied to specific contexts for even granular targeting of assets.

See the section on Basic CDN Sharding to see how custom rules can be used to improve your site's frontend loading performance beyond the advantages already given by caching through KeyCDN.

#### Default Rules
For the purpose of documentation or if you do not select the 'Install Default Rules' option on install and later decide you want to use them, here are the default rules shipped with the MODX KeyCDN Toolkit:

__1. Site URL src and href links__

Replace src and href links that start with the site URL.

* Input Rule: ``((?:<(?:a|link|img|script)\b)(?:[^>]+)(?:href|src)=")(?:{site_url})([^>]+\.(?:jpe?g|png|gif|svg|xml|js|css)")``
* Output Format: ``{match1}{cdn_url}{match2}``

__2. Base URL src and href links__

Replace src and href links that start with the base URL.

* Input Rule: ``((?:<(?:a|link|img|script)\b)(?:[^>]+)(?:href|src)=")(?:{base_url})([^/][^>]+\.(?:jpe?g|png|gif|svg|xml|js|css)")``
* Output Format: ``{match1}{cdn_url}{match2}``

__3. Relative URL src and href links__

Replace relative src and href links.

* Input Rule: ``((?:<(?:a|link|img|script)\b)(?:[^>]+)(?:href|src)=")(?!(?:https?|/))([^>]+\.(?:jpe?g|png|gif|svg|xml|js|css)")``
* Output Format: ``{match1}{cdn_url}{match2}``

### Web fonts

If you want to cache web fonts via KeyCDN, you can add the extensions to the default rules above but please read this [KeyCDN blog article](https://www.keycdn.com/blog/cors-with-a-cdn/) first as the article outlines some important webserver configuration changes required to avoid security issues with some browsers.

### Full-Page Caching

Full-page caching is a different configuration. In a full-page caching scenario, you would configure your pull zone as such:

1. Create an A Record, origin.example.com that points to the IP of your site.
2. Configure your web server, if needed, to route the domain to your MODX install.
3. Create your pull zone, add origin.example.com as your Origin URL and add your site's domain as a custom CDN domain.
4. Change your site's domain to a CNAME record that points to the default CDN URL provided by KeyCDN, xxx.kxcdn.com.
5. Allow time for the DNS changes to propagate but then your site should be getting served via KeyCDN.
6. Install [microcache](https://github.com/opengeek/microcache/) to allow cache headers be set for your MODX resources.
7. Disable the KeyCDN Linker plugin and enable the KeyCDN Manager plugin, this will provide an additional button when saving resources that will allow you to save and then send a purge request to KeyCDN for that particular MODX resource.

## CDN Sharding
CDN sharding is a method whereby assets are served from several different CDN URLs to allow more concurrent requests to be handled by the browser thus resulting in quicker page load times.

First, you will need to make sure you have several alternative CDN URLs specified in the KeyCDN Control Panel. For each rule you create or update, you can assign multiple CDN URLs that will be used. The assigned CDN URLs will utilize a round-robin assignment on a per-rule basis when matches are found via the KeyCDN Linker plugin. This method means you can have different groups of CDN URLs assigned to different rules.

__Note: If you are using the full-page caching strategy, you can still use the Rules Manager to do CDN sharding, just make sure you have the KeyCDN Linker plugin enabled.__

## SSL Support

KeyCDN has free SSL support. SSL can be enabled in the KeyCDN Control Panel. There are two options, Shared SSL and Custom SSL. With Shared SSL, you be assigned a KeyCDN SSL domain that you can usw. With Custom SSL, you can upload your own certificate and specify custom domains covered under that custom domain (for example, a Wildcard SSL certificate would allow you to utilize the CDN sharding detailed above)

When adding a rule, you can select the scheme to use for the CDN URL from one of the following: HTTP, HTTPS, or Schemeless.

__Note: Do not specify HTTPS on any domains that you haven't set up either via the Shared SSL option or Custom SSL in the KeyCDN Control Panel. You will get insecure content loading errors if you do.__

