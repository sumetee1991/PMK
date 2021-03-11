<div class="container">
    <div class="row" style="text-align: center">
        <div class="col" style="margin: 5px;">
            จัดยา <span style="padding: 5px;background-color: #aae5ef;"> จำนวนยาที่จัดเสร็จสิ้น <?= $Data['count']; ?> </span>
        </div>
    </div>
    <hr>
    <div class="container-fluid" style="max-width:600px;">
        <div class="row">
            <p>เวลาจัดยาเฉลี่ยตามประเภทคิว (นาที)</p>
            <canvas id="amountwaiting_bar" dataname="waiting" charttype="barchart" width="400" height="400"></canvas>
            <span>เวลาจัดยานับตั้งแต่เวลาออกคิวเสร็จถึงการจัดยา</span>
        </div>
        <hr>
        <div class="row">
            <p>จำนวนยาที่จัดเสร็จตามช่วงเวลา</p>
            <canvas id="amount_bar" dataname="amount" charttype="barchart" width="400" height="400"></canvas>
        </div>
    </div>

</div>