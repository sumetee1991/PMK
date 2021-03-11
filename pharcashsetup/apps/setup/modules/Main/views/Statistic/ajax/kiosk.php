<div class="container">
    <?php if ($_POST['queuelocationuid'] != '4') : ?>
        <div class="row" style="text-align: center">
            <div class="col" style="margin: 5px;">
                - จำนวนผู้ใช้งาน Kiosk <span style="padding: 5px;background-color: #aae5ef;"> จำนวน <?= $Data['count']; ?>
                    คน </span>
            </div>
        </div>
        <hr>
    <?php elseif ($_POST['queuelocationuid'] == '4') : ?>
        <div class="row" style="text-align: center">
            <div class="col" style="margin: 5px;">
                - จำนวนผู้ใช้งาน Kiosk <span style="padding: 5px;background-color: #aae5ef;"> จำนวน <?= $Data['count_lo4']; ?>
                    คน </span>
            </div>
            <div class="col" style="margin: 5px;">
                - จำนวน VN ที่ออกคิวออนไลน์ไม่ทันผู้ป่วย <span style="padding: 5px;background-color: #aae5ef;"> จำนวน <?= $Data['count_lo4_free']; ?>
                    คน </span>
            </div>
        </div>
        <hr>
    <?php endif; ?>
    <div class="container-fluid" style="max-width:600px;">
        <?php if ($_POST['queuelocationuid'] != '4') : ?>
            <p>- จำนวนผู้ป่วยที่ใช้งานตู้ Kiosk เฉลี่ยตามช่วงเวลา (ช่วงละ 1 ชั่วโมง)</p>
            <div class="row">
                <p>ผู้ป่วยตามช่วงเวลา</p>
                <canvas id="amount_bar" dataname="amount" charttype="barchart" width="400" height="400"></canvas>
            </div>
        <?php elseif ($_POST['queuelocationuid'] == '4') : ?>
            <p>- จำนวนผู้ป่วยที่ใช้งานตู้ Kiosk เฉลี่ยตามช่วงเวลา (ช่วงละ 1 ชั่วโมง)</p>
            <div class="row">
                <p>ผู้ป่วยตามช่วงเวลา</p>
                <canvas id="amount_lo4_Kiosk_total" dataname="amount_lo4_Kiosk_total" charttype="barchart" width="400" height="400"></canvas>
            </div>
            <hr>
            <!-- <p>- จำนวนผู้ป่วยที่ใช้งานตู้ Kiosk เฉลี่ยตามช่วงเวลา (ช่วงละ 1 ชั่วโมง)</p>
            <div class="row">
                <p>ผู้ป่วยตามช่วงเวลา</p>
                <canvas id="amount_lo4_Kiosk" dataname="amount_lo4_Kiosk" charttype="barchart" width="400" height="400"></canvas>
            </div>
            <hr> -->
            <br>
            <p>- จำนวนผู้ป่วย(Walk-in) ที่ใช้งานตู้ Kiosk เฉลี่ยตามช่วงเวลา (ช่วงละ 1 ชั่วโมง)</p>
            <div class="row">
                <p>ผู้ป่วยตามช่วงเวลา</p>
                <canvas id="amount_lo4_Walk_in" dataname="amount_lo4_Walk_in" charttype="barchart" width="400" height="400"></canvas>
            </div>
            <hr>
            <br>
            <p>- จำนวนผู้ป่วย(Online) ที่ใช้งานตู้ Kiosk เฉลี่ยตามช่วงเวลา (ช่วงละ 1 ชั่วโมง)</p>
            <div class="row">
                <p>ผู้ป่วยตามช่วงเวลา</p>
                <canvas id="amount_lo4_Online" dataname="amount_lo4_Online" charttype="barchart" width="400" height="400"></canvas>
            </div>
        <?php endif; ?>
    </div>

</div>