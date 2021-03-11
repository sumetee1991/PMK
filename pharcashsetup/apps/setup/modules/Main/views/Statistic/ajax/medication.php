<div class="container">
    <div class="row" style="text-align: center">
        <div class="col" style="margin: 5px;">
            - จำนวนยาที่จัดเสร็จสิ้น(จากระบบHIS) <span style="padding: 5px;background-color: #aae5ef;"> จำนวน <?= $Data['count_his']; ?> </span>
        </div>
    </div>
    <hr>
    <br>
    <div class="container-fluid" style="max-width:600px;">
        <p>- ระยะเวลาจัดยา เฉลี่ยตามประเภทคิว (เวลาออกคิวคิดราคายา – เวลาจัดยาเสร็จ เฉลี่ย)(จากระบบHIS)</p>
        <div class="row">
            <p>เวลาจัดยา เฉลี่ยตามประเภทคิว</p>
            <canvas id="amount_his_waiting_bar" dataname="waiting_his" charttype="barchart" width="400" height="400"></canvas>
            <span>เวลาจัดยานับตั้งแต่เวลาออกคิวเสร็จสิ้นถึงการจัดยา</span>
        </div>
        <hr>
        <br>
        <p>- จัดยาตามช่วงเวลา (ช่วงละ 1 ชั่วโมง)(จากระบบHIS)</p>
        <div class="row">
            <p>จำนวนยาที่จัดเสร็จตามช่วงเวลา</p>
            <canvas id="amount_his_bar" dataname="amount_his" charttype="barchart" width="400" height="400"></canvas>
        </div>
    </div>
    <hr>
    <br>
    <div class="row" style="text-align: center">
        <div class="col" style="margin: 5px;">
            - จำนวนยาที่จัดเสร็จสิ้น(จากระบบคิว) <span style="padding: 5px;background-color: #aae5ef;"> จำนวน <?= $Data['count']; ?> </span>
        </div>
    </div>
    <br>
    <div class="container-fluid" style="max-width:600px;">
        <p>- ระยะเวลาจัดยา เฉลี่ยตามประเภทคิว (เวลาออกคิวคิดราคายา – เวลาจัดยาเสร็จ เฉลี่ย)(จากระบบคิว)</p>
        <div class="row">
            <p>เวลาจัดยา เฉลี่ยตามประเภทคิว</p>
            <canvas id="amountwaiting_bar" dataname="waiting" charttype="barchart" width="400" height="400"></canvas>
            <span>เวลาจัดยานับตั้งแต่เวลาออกคิวเสร็จถึงการจัดยา</span>
        </div>
        <hr>
        <br>
        <p>- จัดยาตามช่วงเวลา (ช่วงละ 1 ชั่วโมง)(จากระบบคิว)</p>
        <div class="row">
            <p>จำนวนยาที่จัดเสร็จตามช่วงเวลา</p>
            <canvas id="amount_bar" dataname="amount" charttype="barchart" width="400" height="400"></canvas>
        </div>
    </div>

</div>