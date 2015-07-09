KeyCDN.combo.CDNURLs = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        url: KeyCDN.config.connectorUrl
        ,baseParams: {
            action: 'mgr/combos/cdn/getlist'
            ,combo: true
        }
        ,fields: ['cdn_url']
        ,hiddenName: config.name || 'cdn_url'
        ,pageSize: 15
        ,valueField: 'cdn_url'
        ,displayField: 'cdn_url'
    });
    KeyCDN.combo.CDNURLs.superclass.constructor.call(this,config);
};
Ext.extend(KeyCDN.combo.CDNURLs,MODx.combo.ComboBox);
Ext.reg('kcdn-combo-cdnurls',KeyCDN.combo.CDNURLs);

KeyCDN.combo.Scheme = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        store: new Ext.data.JsonStore({
            fields: ['name','scheme']
            ,data: [
                {"name": _('kcdn.http'),"scheme": 'http://'}
                ,{"name": _('kcdn.https'),"scheme": 'https://'}
                ,{"name": _('kcdn.schemeless'),"scheme": '//'}
            ]
        })
        ,displayField: 'name'
        ,valueField: 'scheme'
        ,hiddenName: config.name || 'scheme'
        ,mode: 'local'
        ,triggerAction: 'all'
        ,editable: false
        ,selectOnFocus: false
        ,preventRender: true
        ,forceSelection: true
        ,enableKeyEvents: true
    });
    KeyCDN.combo.Scheme.superclass.constructor.call(this,config);
};
Ext.extend(KeyCDN.combo.Scheme,Ext.form.ComboBox);
Ext.reg('kcdn-combo-scheme',KeyCDN.combo.Scheme);