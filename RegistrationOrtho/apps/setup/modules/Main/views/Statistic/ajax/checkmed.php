<div class="container">
    <div class="row" style="text-align: center">
        <div class="col" style="margin: 5px;">
            เช็คยา <span style="padding: 5px;background-color: #aae5ef;"> จำนวนยาที่ผ่านการเช็คยา <?= $Data['count']; ?> </span>
        </div>
    </div>
    <hr>
    <div class="container-fluid" style="max-width:600px;">
        <div class="row">
            <p>ยาถูกต้อง / ยามีปัญหา</p>
            <canvas id="type_pie" dataname="type" charttype="piechart" width="400" height="400"></canvas>
        </div>
        <hr>
        <div class="row">
            <p>จำนวนยาตามระยะเวลารอ</p>
            <canvas id="amountwaiting_bar" dataname="waiting" charttype="barchart" width="400" height="400"></canvas>
            <span>เวลาเช็คยานับตั้งแต่เวลาจัดยาถึงการเช็คยา</span>
        </div>
        <hr>
        <div class="row">
            <p>จำนวนยาที่เช็คตามช่วงเวลา</p>
            <canvas id="amount_bar" dataname="amount" charttype="barchart" width="400" height="400"></canvas>
        </div>
    </div>

</div>