<div class="container">
    <div class="row" style="text-align: center">
        <div class="col" style="margin: 5px;">
            ทำประวัติ <span style="padding: 5px;background-color: #aae5ef;"> จำนวนผู้ป่วยติดต่อทำประวัติ <?= $data['count']; ?> คน </span>
        </div>
    </div>
    <hr>
    <div class="container-fluid" style="max-width:600px;">
        <div class="row">
            <p>จำนวนผู้ป่วยตามประเภทคิว</p>
            <canvas id="type_pie" dataname="type" charttype="barchart" width="400" height="400"></canvas>
        </div>
        <hr>
        <div class="row">
            <p>จำนวนการทำประวัติผู้ป่วยตามช่วงเวลา</p>
            <canvas id="amount_bar" dataname="amount" charttype="barchart" width="400" height="400"></canvas>
        </div>
        <hr>
        <div class="row">
            <p>ระยะเวลารอทำประวัติ</p>
            <canvas id="amountwaiting_bar" dataname="amountwaiting" charttype="barchart" width="400" height="400"></canvas>
        </div>
    </div>

</div>