<div class="container">
    <div class="row" style="text-align: center">
        <div class="col" style="margin: 5px;">
            - จำนวนผู้ป่วยติดต่อทำประวัติ <span style="padding: 5px;background-color: #aae5ef;"> จำนวน
                <?= $data['count']; ?> คน </span>
        </div>
    </div>
    <hr>
    <div class="container-fluid" style="max-width:600px;">
        <p>- จำนวนผู้ป่วยตามประเภทคิว</p>
        <div class="row">
            <p>ประเภทคิว</p>
            <canvas id="type_pie" dataname="type" charttype="barchart" width="400" height="400"></canvas>
        </div>
        <hr>
        <p>- เสร็จสิ้นตามช่วงเวลา (ช่วงละ 1 ชั่วโมง)</p>
        <div class="row">
            <p>จำนวนผู้ป่วยทำประวัติ</p>
            <canvas id="amount_bar" dataname="amount" charttype="barchart" width="400" height="400"></canvas>
        </div>
        <hr>
        <p>- ระยะเวลารอทำประวัติ (เวลา kiosk-ทำประวัติ แบบ Histogram)</p>
        <div class="row">
            <p>จำนวนยผู้ป่วยตามระยะเวลารอ</p>
            <canvas id="amountwaiting_bar" dataname="amountwaiting" charttype="barchart" width="400"
                height="400"></canvas>
        </div>
    </div>

</div>