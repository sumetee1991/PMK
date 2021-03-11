<div class="container">
    <div class="row" style="text-align: center">
        <div class="col" style="margin: 5px;">
            - จำนวนยาที่ผ่านการเช็คยา(จากระบบคิว) <span style="padding: 5px;background-color: #aae5ef;"> จำนวน <?= $Data['count_total']; ?> </span>
        </div>
    </div>
    <hr>
    <br>
    <div class="container-fluid" style="max-width:600px;">
        <p>- อัตราส่วนยาที่ถูกต้อง / ยามีปัญหา </p>
        <div class="row">
            <p>ยาถูกต้อง / ยามีปัญหา </p>
            <canvas id="type_pie" dataname="type" charttype="piechart" width="400" height="400"></canvas>
        </div>

        <br>
        <div class="col" style="margin: 5px;">
            - เช็คยา <span style="padding: 5px;background-color: #aae5ef;"> จำนวนยาที่มีการเช็คยาทั้งหมด (จากระบบ HIS) <?= $Data['count_his']; ?> </span>
        </div>
        <br>
        <p>- ระยะเวลารอเช็คยา (เวลาออกคิวยา – เวลาเช็คยา แบบ Histogram ช่วงละ 10 นาที)(จากระบบ HIS)</p>
        <div class="row">
            <p>จำนวนยาตามระยะเวลารอ </p>
            <canvas id="amountwaiting_his_bar" dataname="waiting_his" charttype="barchart" width="400" height="400"></canvas>
            <span>เวลาเช็คยานับตั้งแต่เวลาออกคิวยาถึงการเช็คยา</span>
        </div>
        <hr>
        <br>
        <p>- จำนวนยาที่เช็คตามช่วงเวลา (ช่วงละ 1 ชม.)(จากระบบ HIS)</p>
        <div class="row">
            <p>จำนวนยาที่เช็คตามช่วงเวลา</p>
            <canvas id="amount_his_bar" dataname="amount_his" charttype="barchart" width="400" height="400"></canvas>
        </div>
        <hr>
        <br>
        <div class="col" style="margin: 5px;">
            - จำนวนยาที่ผ่านการเช็คยา(จากระบบคิว) <span style="padding: 5px;background-color: #aae5ef;"> จำนวน <?= $Data['count_queue']; ?> </span>
        </div>
        <br>
        <p>- ระยะเวลารอเช็คยา (เวลาออกคิวยา – เวลาเช็คยา แบบ Histogram ช่วงละ 10 นาที)(จากระบบคิว)</p>
        <div class="row">
            <p>จำนวนยาตามระยะเวลารอ</p>
            <canvas id="amountwaiting_bar" dataname="waiting_queue" charttype="barchart" width="400" height="400"></canvas>
            <span>เวลาเช็คยานับตั้งแต่เวลาออกคิวยาถึงการเช็คยา</span>
        </div>
        <hr>
        <br>
        <p>- จำนวนยาที่เช็คตามช่วงเวลา (ช่วงละ 1 ชม.)(จากระบบคิว)</p>
        <div class="row">
            <p>จำนวนยาตามระยะเวลารอ </p>
            <canvas id="amount_bar" dataname="amount_queue" charttype="barchart" width="400" height="400"></canvas>
        </div>
    </div>

</div>