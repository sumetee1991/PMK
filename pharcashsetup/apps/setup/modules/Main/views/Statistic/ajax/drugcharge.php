<div class="container">
    <div class="row" style="text-align: center">
        <div class="col" style="margin: 5px;">
            - จำนวนผู้ป่วยติดต่อคิดราคายา <span style="padding: 5px;background-color: #aae5ef;"> จำนวน
                <?= $Data['count_DrugCharge']; ?> คน </span>
        </div>
    </div>
    <hr>
    <div class="container-fluid" style="max-width:600px;">
        <p>- ระยะเวลารอคิดราคายา (เวลา Kiosk-กดเรียกคิวคิดราคายาครั้งแรก แบบ Histogram ช่วงละ 5 นาที)</p>
        <div class="row">
            <p>จำนวนผู้ป่วยตามระยะเวลารอ</p>
            <canvas id="amountwaiting_bar" dataname="waiting" charttype="barchart" width="400" height="400"></canvas>
            <span>เวลารอคิดราคายานับตั้งแต่เวลากดคิวจากคีออสถึงการเรียกคิวคิดราคายาครั้งแรก</span>
        </div>
        <hr>
        <br>
        <p>- เรียกคิวตามช่วงเวลา (ช่วงละ 1 ชั่วโมง)</p>
        <div class="row">
            <p>ผู้ป่วยตามช่วงเวลารอ</p>
            <canvas id="amount_bar" dataname="amount" charttype="barchart" width="400" height="400"></canvas>
        </div>
        <hr>
        <br>
        <?php if ($_POST['queuelocationuid'] == '4') : ?>

            <div class="col" style="margin: 5px;">
                - จำนวนผู้ป่วยที่ออกคิวยา <span style="padding: 5px;background-color: #aae5ef;"> จำนวน
                    <?= $Data['count_Kiosk']; ?> คน </span>
            </div>
            <br>
            <p>- อัตราส่วนประเภทผู้ป่วย Online / Walk-in</p>
            <div class="row">
                <p>ประเภทผู้ป่วย</p>
                <canvas id="type_lo4_pie" dataname="type_lo4" charttype="piechart" width="400" height="400"></canvas>
            </div>
            <hr>
            <br>
        <?php endif; ?>
        <div class="col" style="margin: 5px;">
            - จำนวนผู้ป่วยที่ออกคิวยา <span style="padding: 5px;background-color: #aae5ef;"> จำนวน
                <?= $Data['count_Cashier']; ?> คน </span>
        </div>
        <br>
        <p>- อัตราส่วนประเภทผู้ป่วยที่ต้อง ติดต่อการเงิน / ไม่ติดต่อการเงิน</p>
        <div class="row">
            <p>ประเภทผู้ป่วย</p>
            <canvas id="type_pie" dataname="type" charttype="piechart" width="400" height="400"></canvas>
        </div>
        <hr>
        <br>
        <p>- อัตราส่วนการออกคิวแต่ละประเภท</p>
        <div class="row">
            <p>ผู้ป่วยตามประเภทคิว</p>
            <canvas id="queuecate_bar" dataname="queuecate" charttype="barchart" width="400" height="400"></canvas>
        </div>
        <hr>
        <br>
    </div>

</div>