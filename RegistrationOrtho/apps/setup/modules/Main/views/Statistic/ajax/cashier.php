<div class="container">
    <div class="row" style="text-align: center">
        <div class="col" style="margin: 5px;">
            การเงิน <span style="padding: 5px;background-color: #aae5ef;"> จำนวนผู้ป่วยติดต่อการเงิน <?= $Data['count']; ?> คน </span>
        </div>
    </div>
    <hr>
    <div class="container-fluid" style="max-width:600px;">
        <div class="row">
            <p>ผู้ป่วยตามประเภทคิว</p>
            <canvas id="queuecate_bar" dataname="queuecate" charttype="barchart" width="400" height="400"></canvas>
        </div>
        <hr>
        <div class="row">
            <p>จำนวนผู้ป้วยที่ใช้สิทธิต่างๆ</p>
            <canvas id="credit_pie" dataname="credit" charttype="piechart" width="400" height="400"></canvas>
        </div>
        <hr>
        <div class="row">
            <p>จำนวนผู้ป่วยตามระยะเวลารอ</p>
            <canvas id="amountwaiting_bar" dataname="waiting" charttype="barchart" width="400" height="400"></canvas>
            <span>เวลารอติดต่อการเงินนับตั้งแต่เวลาออกคิวคิดราคายาถึงติดต่อการเงินเสร็จสิ้น</span>
        </div>
        <hr>
        <div class="row">
            <p>ผู้ป่วยตามช่วงเวลา</p>
            <canvas id="amount_bar" dataname="amount" charttype="barchart" width="400" height="400"></canvas>
        </div>
    </div>

</div>