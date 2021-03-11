<div class="container">
    <div class="row" style="text-align: center">
        <div class="col" style="margin: 5px;">
            - จำนวนที่ผู้ป่วยที่ต้องมารับยา <span style="padding: 5px;background-color: #aae5ef;"> จำนวน <?= $Data['count']; ?> คน </span>
        </div>
    </div>
    <hr>
    <div class="container-fluid" style="max-width:600px;">
        <p>ระยะเวลายารอจ่าย (เวลาเช็คยา – เรียกคิวครั้งแรกของจ่ายยา แบบ Histogram ช่วงละ 5 นาที)</p>
        <div class="row">
            <p>จำนวนยาตามระยะเวลารอ</p>
            <canvas id="amountwaiting_bar" dataname="waiting" charttype="barchart" width="400" height="400"></canvas>
            <span>หมายเหตุ: ไม่รวมคิวที่มีการ Hold</span>
        </div>
        <hr>
        <br>
        <!-- <div class="row">
            <p>ระยะเวลารอจ่ายยาของผู้ป่วย เฉลี่ยตามประเภทคิว (เวลาออกคิวยา – กด call ครั้งแรก เฉลี่ย)</p>
            <canvas id="typetime_bar" dataname="typetime" charttype="barchart" width="400" height="400"></canvas>
        </div>
        <hr>
        <br> -->
        <p>- กด call ครั้งแรกตามช่วงเวลา (ช่วงละ1 ชั่วโมง)</p>
        <div class="row">
            <p>ผู้ป่วยตามช่วงเวลา</p>
            <canvas id="amount_bar" dataname="amount" charttype="barchart" width="400" height="400"></canvas> 
        </div>
        <hr>
        <br>
        <p>- ระยะเวลารวมที่ผู้ป่วยใช้ที่การเงินรับยา เฉลี่ยตามประเภทคิว (เวลาออกคิวยา – เรียกคิวจ่ายยาครั้งแรก เฉลี่ย)</p>
        <div class="row">
            <p>เวลาที่ผู้ป่วยใช้ที่การเงินรับยา เฉลี่ยตามประเภทคิว(นาที)</p>
            <canvas id="amountqueuecatetime_bar" dataname="amountqueuecatetime" charttype="barchart" width="400" height="400"></canvas>
            <span>หมายเหตุ: ไม่รวมคิวที่มีการ Hold</span>
        </div>
        <hr>
        <br>
        <p>- ระยะเวลารวมที่ผู้ป่วยใช้ที่การเงินรับยา เฉลี่ยตามประเภทคิว (เวลา Kiosk – เรียกคิวจ่ายยาครั้งแรก เฉลี่ย)</p>
        <div class="row">
            <p>เวลาที่ผู้ป่วยใช้ที่การเงินรับยา เฉลี่ยตามประเภทคิว(นาที)</p>
            <canvas id="amountqueuetime_bar" dataname="amountqueuetime" charttype="barchart" width="400" height="400"></canvas>
            <span>หมายเหตุ: ไม่รวมคิวที่มีการ Hold</span>
        </div>
    </div>

</div>