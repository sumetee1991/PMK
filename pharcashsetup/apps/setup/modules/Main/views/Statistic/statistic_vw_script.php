<script type="text/javascript">
    $( function() {
        
        const dynamicColors = () => {
            var r = Math.floor(Math.random() * 255);
            var g = Math.floor(Math.random() * 255);
            var b = Math.floor(Math.random() * 255);
            return `rgb(${r}, ${g}, ${b})`;
        }
        const drawChart = async (Type,ID,Data,setLegend = true) => {
            let labels = new Array();
            let datasets = new Array();
            let maxValue = 0;
            datasets.data = new Array();
            datasets.backgroundColor = new Array();
            datasets.borderColor = new Array();
            await Data.forEach(function(value, index){
                let thisColor = dynamicColors();
                labels.push(value.labels);
                maxValue = value.data > maxValue ? value.data : maxValue;
                datasets['data'].push(value.data);
                datasets['backgroundColor'].push(thisColor);
                datasets['borderColor'].push('rgb(255,255,255)');
                console.log(maxValue);
            })
            await console.log(` final ${maxValue}`);
            var ctx = document.getElementById(ID);
            let ChartData = {
                type: Type,
                data: {
                    labels: labels,
                    datasets: [{
                        data: datasets['data'],
                        backgroundColor: datasets['backgroundColor'],
                        borderColor: datasets['borderColor'],
                        borderWidth: 1
                    }]
                },
                options: {
                    legend: {
                        display: setLegend,
                        position: 'bottom'
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                max: (maxValue*1.5 + maxValue*0.2)
                            }
                        }]
                    },
                    plugins:{
                        labels: {
                            render: 'value',
                            fontSize: 14,
                            fontStyle: 'bold',
                            fontColor: '#000',
                            position: 'outside'
                        }
                    }
                }
            };
            var myChart = await new Chart(ctx, ChartData);
        }
        const drawPieChart = (ID,Data) => {
            drawChart('pie',ID,Data);
        }
        const drawBarChart = (ID,Data) => {
            drawChart('bar',ID,Data,false);
        }

        $(document).on('submit','[form_stop]',function(e){
            let formURL = $(this).attr('action');
            let formData = $(this).serialize();            
            $('#show_stat').html('');
            $('#loading').css('display', 'block');
            $.post(formURL,formData)
                .done( (data) => {
                    console.log(data);
                    $('#show_stat').html(data.html);
                    $("canvas").each(function(){
                        let thisChartID = $(this).attr('id');
                        let thisChartType = $(this).attr('charttype');
                        let thisChartData = $(this).attr('dataname');
                        switch(thisChartType){
                            case 'piechart':
                                drawPieChart(thisChartID,data.stat[thisChartData]);
                            break;
                            case 'barchart':
                                drawBarChart(thisChartID,data.stat[thisChartData]);
                            break;
                        }
                    });
                    //drawPieChart('myChart',data.stat.type);
                    $('#loading').css('display', 'none');
                })
                .fail( () => {
                    $('#show_stat').html("Try Again");
                    $('#loading').css('display', 'none');
                });

            return false;
        });

    });
</script>