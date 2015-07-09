Ext.onReady(function() {
    MODx.load({ xtype: 'kcdn-page-home', renderTo: 'kcdn-wrapper-div'});
});
 
KeyCDN.page.Home = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'kcdn-page-home'
        ,cls: 'container form-with-labels'
        ,layout: 'form'
        ,border: false
        ,components: [{
            xtype: 'panel'
            ,html: '<h2>'+_('kcdn.desc')+'</h2>'
            ,border: false
            ,cls: 'modx-page-header'
        },{
            xtype: 'form'
            ,id: 'kcdn-formpanel-home'
            ,border: false
            ,items: [{
                xtype: 'modx-tabs'
                ,id: 'kcdn-tabs'
                ,width: '98%'
                ,padding: 10
                ,border: true
                ,deferredRender: false
                ,defaults: {
                    border: false
                    ,autoHeight: true
                    ,defaults: {
                        border: false
                    }
                }
                ,items: [{
                    title: _('kcdn.reporting')
                    ,items: [{
                        html: '<h2 class="kcdn-logo"><img src=" ' + KeyCDN.config.assetsUrl + 'images/keycdn-logo.png" /></h2>' +
                            '<div id="kcdn-chart-line-daily"></div>' +
                            '<div id="kcdn-chart-column-storage"></div>'
                    }]
                },{
                    title: _('kcdn.rules')
                    ,items: [{
                        xtype: 'kcdn-grid-rules'
                        ,preventRender: true
                    }]
                },{
                    title: _('kcdn.purge')
                    ,items: this.getPurgeFields(config)
                }]
                ,stateful: true
                ,stateId: 'kcdn-page-home'
                ,stateEvents: ['tabchange']
                ,getState: function() {
                    return {
                        activeTab:this.items.indexOf(this.getActiveTab())
                    };
                }
                ,listeners: {
                    'tabchange': function(tp, t) {
                        var idx = tp.items.indexOf(t);
                        if (idx == 0) {
                            refreshReporting();
                        }
                    }
                }
            }]
        }]
    });
    KeyCDN.page.Home.superclass.constructor.call(this,config);
};
Ext.extend(KeyCDN.page.Home,MODx.Component,{
    getPurgeFields: function(config) {
        config.id = config.id || Ext.id();
        var s = [{
            layout:'form'
            ,border: false
            ,anchor: '100%'
            ,defaults: {
                labelSeparator: ''
                ,labelAlign: 'top'
                ,border: false
                ,layout: 'form'
                ,msgTarget: 'under'
            }
            ,items:[{
                defaults: {
                    border: false
                    ,msgTarget: 'under'
                }
                ,items: [{
                    xtype: 'xcheckbox'
                    ,boxLabel: _('kcdn.purge_all')
                    ,hideLabel: true
                    ,id: config.id + 'kcdn-purge-all'
                    ,name: 'purge_all'
                    ,value: 1
                    ,checked: false
                    ,handler: function(o,v) {
                        if (v == true) {
                            Ext.getCmp(config.id + 'kcdn-purge-files').disable().setValue('');
                        } else {
                            Ext.getCmp(config.id + 'kcdn-purge-files').enable();
                        }
                    }
                },{
                    xtype: 'textarea'
                    ,fieldLabel: _('kcdn.purge_files')
                    ,id: config.id + 'kcdn-purge-files'
                    ,name: 'purge_files'
                    ,anchor: '100%'
                    ,width: '100%'
                    ,height: 200
                },{
                    html: '<p><i>' + _('kcdn.purge_files_desc') + '</i></p>'
                }]
            }]
            ,buttonAlign: 'center'
            ,buttons: [{
                xtype: 'button'
                ,text: _('kcdn.purge')
                ,scope: this
                ,handler: this.purge
            }]
        }];
        return s;
    }

    ,purge: function() {
        Ext.Ajax.request({
            url: KeyCDN.config.connectorUrl
            ,params: {
                action: 'mgr/files/purge'
                ,purge_all: Ext.getCmp(this.config.id + 'kcdn-purge-all').getValue()
                ,purge_files: Ext.getCmp(this.config.id + 'kcdn-purge-files').getValue()
            }
            ,scope: this
            ,success: function(r) {
                var response = Ext.decode(r.responseText);
                MODx.msg.alert(_('kcdn.purge'), response.message);

                Ext.getCmp(this.config.id + 'kcdn-purge-all').setValue(false);
                Ext.getCmp(this.config.id + 'kcdn-purge-files').setValue('');
            }
        });
    }

});
Ext.reg('kcdn-page-home', KeyCDN.page.Home);