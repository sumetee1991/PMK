<div class="container">
    <div class="row" style="text-align: center">
        <div class="col" style="margin: 5px;">
            Topic <span style="padding: 5px;background-color: #aae5ef;"> Count <?= $Data['count']; ?> </span>
        </div>
    </div>
    <hr>
    <div class="container-fluid" style="max-width:600px;">
        <div class="row">
            <p>Bar Chart</p>
            <canvas id="chart_bar" dataname="" charttype="barchart" width="400" height="400"></canvas>
        </div>
        <hr>
        <div class="row">
            <p>Pie Chart</p>
            <canvas id="chart_pie" dataname="" charttype="piechart" width="400" height="400"></canvas>
        </div>
    </div>

</div>