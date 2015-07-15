KeyCDN.combo.CDNURLs = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        xtype: 'superboxselect'
        ,mode: 'remote'
        ,triggerAction: 'all'
        ,extraItemCls: 'x-tag'
        ,expandBtnCls: 'x-form-trigger'
        ,clearBtnCls: 'x-form-trigger'
        ,fields: ['cdn_url']
        ,displayField: 'cdn_url'
        ,valueField: 'cdn_url'
        ,store: new Ext.data.JsonStore({
                 id:'cdn_url'
                ,url: KeyCDN.config.connectorUrl
                ,root:'results'
                ,fields: ['cdn_url']
                ,baseParams: {
                    action: 'mgr/combos/cdn/getlist'
                }
        })
        ,pageSize: 15
        ,hiddenName: 'cdn_url[]'
    });
    KeyCDN.combo.CDNURLs.superclass.constructor.call(this,config);
};
Ext.extend(KeyCDN.combo.CDNURLs,Ext.ux.form.SuperBoxSelect);
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
