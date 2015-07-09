KeyCDN.window.Rule = function(config) {
    config = config || {};
    config.id = config.id || Ext.id(),
        Ext.applyIf(config,{
            title: (config.isUpdate) ?
                _('kcdn.update_rule') :
                _('kcdn.add_rule')
            ,autoHeight: true
            ,url: KeyCDN.config.connectorUrl
            ,baseParams: {
                action: (config.isUpdate) ?
                    'mgr/rules/update' :
                    'mgr/rules/create'
            }
            ,width: 750
            ,fields: [{
                xtype: 'hidden',
                name: 'id'
            },{
                layout: 'column',
                items: [{
                    columnWidth: 0.75
                    ,layout: 'form'
                    ,items: [{
                        xtype: 'textfield'
                        ,name: 'name'
                        ,fieldLabel: _('kcdn.name')
                        ,allowBlank: false
                        ,anchor: '100%'
                    },{
                        xtype: 'textarea'
                        ,name: 'description'
                        ,fieldLabel: _('kcdn.description')
                        ,anchor: '100%'
                    },{
                        xtype: 'kcdn-combo-scheme'
                        ,name: 'scheme'
                        ,fieldLabel: _('kcdn.scheme')
                        ,allowBlank: false
                        ,anchor: '50%'
                    },{
                        xtype: 'kcdn-combo-cdnurls'
                        ,name: 'cdn_url'
                        ,fieldLabel: _('kcdn.cdn_url')
                        ,allowBlank: false
                        ,anchor: '100%'
                    }]
                },{
                    columnWidth: 0.25,
                    layout: 'form',
                    items: [{
                        xtype: 'numberfield'
                        ,name: 'sortorder'
                        ,fieldLabel: _('kcdn.sortorder')
                        ,allowBlank: false
                        ,minValue: 0
                        ,maxValue: 9999999999
                        ,anchor: '100%'
                        ,value: 0

                    },{
                        xtype: 'modx-combo-content-type'
                        ,name: 'content_type'
                        ,fieldLabel: _('kcdn.content_type')
                        ,allowBlank: false
                        ,anchor: '100%'
                    },{
                        xtype: 'checkbox'
                        ,name: 'disabled'
                        ,fieldLabel: _('kcdn.disabled')
                        ,anchor: '100%'
                    },{
                        xtype: 'checkbox'
                        ,id: config.id + 'kcdn-checkbox-all-contexts'
                        ,name: 'all_contexts'
                        ,fieldLabel: _('kcdn.all_contexts')
                        ,anchor: '100%'
                        ,itemCls: 'kcdn-all-contexts'
                        ,handler: function(o,v) {
                            if (v == true) {
                                Ext.getCmp(config.id + 'kcdn-combo-context').disable();
                            } else {
                                Ext.getCmp(config.id + 'kcdn-combo-context').enable();
                            }
                        }
                    },{
                        xtype: 'modx-combo-context'
                        ,id: config.id + 'kcdn-combo-context'
                        ,name: 'context'
                        ,fieldLabel: _('kcdn.context')
                        ,anchor: '100%'
                    }]
                }]
            },{
                xtype: 'textarea'
                ,name: 'input'
                ,fieldLabel: _('kcdn.input')
                ,anchor: '100%'
            },{
                xtype: 'textarea'
                ,name: 'output'
                ,fieldLabel: _('kcdn.output')
                ,anchor: '100%'
            }]
            ,keys: [] /*prevent enter in textarea from firing submit */
        });
    KeyCDN.window.Rule.superclass.constructor.call(this,config);
    this.on('beforeshow', this.setup, this);
};
Ext.extend(KeyCDN.window.Rule,MODx.Window, {
    setup: function(w) {
        if (w.config.isUpdate !== true) {
            Ext.getCmp(w.config.id + 'kcdn-checkbox-all-contexts').setValue(true);
            Ext.getCmp(w.config.id + 'kcdn-combo-context').disable();
        } else {
            if (Ext.getCmp(w.config.id + 'kcdn-checkbox-all-contexts').getValue() == true) {
                Ext.getCmp(w.config.id + 'kcdn-combo-context').disable();
            }
        }
    }
});
Ext.reg('kcdn-window-rule',KeyCDN.window.Rule);
