google.load('visualization', '1', {'packages':['corechart']});
google.load('visualization', '1', {'packages':['geochart']});
google.load('visualization', '1', {'packages':['table']});

var dailyChart = function() {
    Ext.Ajax.request({
        url: KeyCDN.config.connectorUrl
        ,params: {
            'action' : 'mgr/reporting/daily'
        }
        ,success: function(r) {
            var tp = Ext.getCmp('kcdn-tabs');
            if (tp) {
                var t = tp.getActiveTab();
                var idx = tp.items.indexOf(t);
                if (idx == 0) {
                    var data = new google.visualization.DataTable(r.responseText);
                    var chart = new google.visualization.AreaChart(document.getElementById('kcdn-chart-line-daily'));
                    chart.draw(data, {
                        chartArea: {
                            width: '85%'
                        }
                        ,vAxes: {
                            0: {title: _('kcdn.reporting_hits')}
                        }
                        ,series: {
                            0: {
                                color: '#3586BE'
                            }
                            ,1: {
                                color: '#848484'
                            }
                        }
                        ,lineWidth: 3
                        ,pointSize: 1.3
                        ,pointWidth: 3
                        ,legend: {
                            position: 'bottom'
                        }
                        ,hAxis: {
                            showTextEvery: 7,
                            maxTextLines: 1,
                            maxAlternation: 1
                        }
                    });
                }
            }
        }
    });
}

var storageChart = function() {
    Ext.Ajax.request({
        url: KeyCDN.config.connectorUrl
        ,params: {
            'action' : 'mgr/reporting/storage'
        }
        ,success: function(r) {
            var tp = Ext.getCmp('kcdn-tabs');
            if (tp) {
                var t = tp.getActiveTab();
                var idx = tp.items.indexOf(t);
                if (idx == 0) {
                    var data = new google.visualization.DataTable(r.responseText);
                    var chart = new google.visualization.ColumnChart(document.getElementById('kcdn-chart-column-storage'));
                    chart.draw(data, {
                        chartArea: {
                            width: '85%'
                        }
                        ,vAxis: {title: _('kcdn.reporting_storage'), viewWindow: { min: 0}}
                        ,series: {
                            0: {
                                color: '#3586BE'
                            }
                        }
                        ,lineWidth: 3
                        ,pointSize: 1.3
                        ,pointWidth: 3
                        ,legend: {
                            position: 'bottom'
                        }
                        ,hAxis: {
                            showTextEvery: 7,
                            maxTextLines: 1,
                            maxAlternation: 1
                        }
                    });
                }
            }
        }
    });
}

var refreshReporting = function() {
    dailyChart();
    storageChart();
}

Ext.onReady(function() {
    /* only load reporting if Reporting tab is selected */
    var tp = Ext.getCmp('kcdn-tabs');
    if (tp) {
        var t = tp.getActiveTab();
        var idx = tp.items.indexOf(t);
        if (idx == 0) {
            refreshReporting();
        }
    }
});


Ext.EventManager.onWindowResize(function() {
    dailyChart();
    storageChart;
});