<div class="container">
    <div class="row" style="text-align: center">
        <div class="col" style="margin: 5px;">
            จ่ายยา <span style="padding: 5px;background-color: #aae5ef;"> จำนวนที่ผู้ป่วยที่ต้องมารับยา <?= $Data['count']; ?> คน </span>
        </div>
    </div>
    <hr>
    <div class="container-fluid" style="max-width:600px;">
        <div class="row">
            <p>จำนวนยาตามระยะเวลารอ</p>
            <canvas id="amountwaiting_bar" dataname="waiting" charttype="barchart" width="400" height="400"></canvas>
        </div>
        <hr>
        <div class="row">
            <p>เวลารอจ่ายยาเฉลี่ยตามประเภทคิว (คิว)</p>
            <canvas id="typetime_bar" dataname="typetime" charttype="barchart" width="400" height="400"></canvas>
            <span>เวลารอจ่ายยานับตั้งแต่เวลาเช็คยาถึงการจ่ายยาเสร็จสิ้น</span>
        </div>
        <hr>
        <div class="row">
            <p>ผู้ป่วยตามช่วงเวลา</p>
            <canvas id="amount_bar" dataname="amount" charttype="barchart" width="400" height="400"></canvas>
        </div>
        <hr>
        <div class="row">
            <p>เวลาที่ผู้ป่วยใช้ที่การเงินรับยา เฉลี่ยตามประเภทคิว (นาที)</p>
            <canvas id="amountqueuecatetime_bar" dataname="amountqueuecatetime" charttype="barchart" width="400" height="400"></canvas>
        </div>
    </div>

</div>