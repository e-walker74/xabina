// Inline Charts examples

$(".linecharts").sparkline();
$(".barcharts").sparkline('html', {type: 'bar'});

// Composite line charts, the second using values supplied via javascript
$('#compositeline').sparkline('html', { fillColor: false, changeRangeMin: 0, chartRangeMax: 10 });
$('#compositeline').sparkline([4,1,5,7,9,9,8,7,6,6,4,7,8,4,3,2,2,5,6,7], {composite: true, fillColor: false, lineColor: 'red', changeRangeMin: 0, chartRangeMax: 10 });


// Bar + line composite charts
$('#compositebar').sparkline('html', { type: 'bar', barColor: '#aaf' });
$('#compositebar').sparkline([4,1,5,7,9,9,8,7,6,6,4,7,8,4,3,2,2,5,6,7], {composite: true, fillColor: false, lineColor: 'red' });


// Discrete charts
$('#discrete1').sparkline('html', { type: 'discrete', lineColor: 'blue', xwidth: 18 });
$('#discrete2').sparkline('html', { type: 'discrete', lineColor: 'blue', thresholdColor: 'red', thresholdValue: 4 });

$("#pie").sparkline([1,2,3], {type: 'pie'});

// Large Charts

$("#bigline").sparkline([5,4,4,7,6,9,5,8,2,6,4,6,7,4,2,1,5,7,2,1,4,2,0,3,6,3], {
    type: 'line',
    width: '100%',
    height: '200px',
    lineColor: '#615ef2',
    fillColor: '#f5f6f7',
    highlightSpotColor: '#13b213',
    highlightLineColor: '#f95e5e',
    spotRadius: 2});
$("#bigline").sparkline([4,3,0,6,6,8,5,9,3,8,7,8,7,6,6,4,5,6,3,3,4,3,3,5,5,6], {
    type: 'line',
    width: '100%',
    height: '200px',
    lineColor: '#5eb9f2',
    fillColor: false,
    highlightSpotColor: '#13b213',
    highlightLineColor: '#f95e5e',
    composite: true,
    spotRadius: 2});


$("#bigpie").sparkline([5,3,4,1 ], {type: 'pie', height: '200px'});

$('#bigstacked').sparkline([5,4,7,6,9,5,8,2,6,4,6,7,6,4,2,1,4,6,2,5,7,2,3,5,3,7,9], { type: 'bar', barColor: '#aaf', height: '200px',width: '100%', barWidth: 10, barSpacing: 5});
$('#bigstacked').sparkline([4,1,5,7,9,9,8,7,6,6,4,7,8,4,3,2,2,5,6,7,8], { composite: true, fillColor: false, lineColor: 'red', height: '200px', width: '100%' });