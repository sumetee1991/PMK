<style>
    p {
        font-size: 30px;
    }
</style>
<div class="container">
    <div class="row" style="text-align: center">
        <div class="col" style="margin: 5px;">
        - จำนวนผู้ใช้งานตู้ Kiosk <span style="padding: 5px;background-color: #aae5ef;"> จำนวน<?= $data['count']; ?> คน </span>
        </div>
    </div>
    <hr>
    <div class="container-fluid" style="max-width:600px;">
        <!-- <div class="row">
            <p>อัตราส่วนประเภทผู้ป่วย</p>
            <canvas id="type_pie" dataname="type" charttype="piechart" width="400" height="400"></canvas>
        </div>
        <hr> -->
        <p>- อัตราส่วนสิทธิการรักษา</p>
        <div class="row">
            <p>ประเภทสิทธิ</p>
            <canvas id="payor_pie" dataname="payor" charttype="piechart" width="400" height="400"></canvas>
        </div>
        <hr>
        <p>- อัตราส่วนประเภทการรับบริการ</p>
        <div class="row">
            <p>ประเภทการรับบริการ</p>
            <canvas id="worklistgroup_pie" dataname="worklistgroup" charttype="piechart" width="400" height="400"></canvas>
        </div>
        <hr>
        <p>- จำนวนผู้ใช้งานตู้ Kiosk ตามช่วงเวลา(ช่วงละ 1 ชม.)</p>
        <div class="row">
            <p>ผู้ป่วยตามช่วงเวลา</p>
            <canvas id="amount_bar" dataname="amount" charttype="barchart" width="400" height="400"></canvas>
        </div>
    </div>

</div>