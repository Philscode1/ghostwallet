if (chartValues.length != 0 ) {
    document.getElementById("pie-chart").style.display= "block";
}
Chart.register(ChartDataLabels);

var chartValuesInt = [];
length = chartValues[0].length;
for (var i = 0; i < length; i++)
chartValuesInt.push(parseInt(chartValues[0][i]));

var data = [{
    data: chartValuesInt,
        chartIds,
    backgroundColor: [  
        "#f38000",
        "#5f44f5",
        "#333333",

    ],
    borderColor: "#000"
}];

//Pie Click Event Link
function graphClickEvent(event, array){
    if(array[0]){
        let clickIndex=array[0].index; 
        let urlId = data[0].chartIds[0][clickIndex];
        // console.log(urlId)
        window.location.href = "http://127.0.0.1:8000/home/"+urlId;
        // window.location.href = "http://ghostwallet.net/home/"+urlId;
    }
}

var options = {
    borderWidth: 4,
    hoverOffset: 6,
    onClick: graphClickEvent,
    plugins: {
        legend: {
            display: false
        },
        tooltip: {
            enabled: false,
            
        },
        datalabels: {
            //Label Symbol, Percentage, Value
            formatter: (value, ctx) => {
                let sum = 0;
                let dataArr = ctx.chart.data.datasets[0].data;
                dataArr.map(data => {
                    sum += data;
                });
                let percentage = (value*100 / sum).toFixed(2)+"%";
                return [ctx.chart.data.labels[ctx.dataIndex],
                percentage,   
                '$' + value ] ;
            },
            textAlign: 'center',
            color: '#fff',
            borderRadius: 50,
            padding:10,
            labels: {
                title: {
                    font: {
                        weight: 'bold',
                        size: '16px'
                    }
                },
            },
            //Hover Cursor
            listeners: {
                enter: function(context) {
                    context.hovered = true;
                    var el = document.getElementById("pie-chart");
                    el.style.cursor = "pointer";
                    return true;
                },
                leave: function(context) {
                    context.hovered = false;
                    var el = document.getElementById("pie-chart");
                    el.style.cursor = "default";
                    return true;
                },
            },
        }
    },
};

//IMAGE CENTER
const image = new Image();
image.src = 'img/pie-home2.png';

const plugin = {
    id: 'custom_canvas_background_image',
    beforeDraw: (chart) => {
        if (image.complete) {
        const ctx = chart.ctx;
        const {top, left, width, height} = chart.chartArea;
        const x = left + width / 2 - image.width / 2;
        const y = top + height / 2 - image.height / 2;
        ctx.drawImage(image, x, y);
        } else {
        image.onload = () => chart.draw();
        }
    }
};

var ctx = document.getElementById("pie-chart").getContext('2d');
var myChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: chartLabels[0],
        datasets: data,
        
    },
    options: options,
    plugins: [plugin],
});
