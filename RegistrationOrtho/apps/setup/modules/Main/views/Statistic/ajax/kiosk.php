<div class="container">
    <div class="row" style="text-align: center">
        <div class="col" style="margin: 5px;">
            Kiosk <span style="padding: 5px;background-color: #aae5ef;"> จำนวนผู้ใช้งาน <?= $Data['count']; ?> คน </span>
        </div>
    </div>
    <hr>
    <div class="container-fluid" style="max-width:600px;">
        <div class="row">
            <p>จำนวนผู้ป่วยใช้งานตู้ Kiosk เฉลี่ยตามช่วงเวลา</p>
            <canvas id="amount_bar" dataname="amount" charttype="barchart" width="400" height="400"></canvas>
        </div>
    </div>

</div>