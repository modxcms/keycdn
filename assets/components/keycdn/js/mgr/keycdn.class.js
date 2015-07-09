var KeyCDN = function(config) {
    config = config || {};
    KeyCDN.superclass.constructor.call(this,config);
};
Ext.extend(KeyCDN,Ext.Component,{
    page:{},window:{},grid:{},tree:{},panel:{},tabs:{},combo:{},
    config: {
        connector_url: ''
    },
    inVersion: false
});
Ext.reg('keycdn',KeyCDN);
KeyCDN = new KeyCDN();
