<style>
p {
    font-size: 30px;
}
</style>
<div class="container">
    <div class="row" style="text-align: center">
        <div class="col" style="margin: 5px;">
            - จำนวนผู้ป่วยติดต่อเปิดสิทธิ <span style="padding: 5px;background-color: #aae5ef;"> จำนวน
                <?= $data['count']; ?> คน </span>
        </div>
    </div>
    <hr>
    <div class="container-fluid" style="max-width:600px;">
        <p>- จำนวนผู้ป่วยตามประเภทคิว</p>
        <div class="row">
            ประเภทคิว
            <canvas id="type_pie" dataname="type" charttype="barchart" width="400" height="400"></canvas>
        </div>
        <hr>
        <p>- เสร็จสิ้นตามช่วงเวลา (ช่วงละ 1 ชั่วโมง)</p>
        <div class="row">
            จำนวนผู้ป่วยเปิดสิทธิ
            <canvas id="amount_bar" dataname="amount" charttype="barchart" width="400" height="400"></canvas>
        </div>
        <hr>
        <p>- ระยะเวลารอเปิดสิทธิตามประเภทผู้ป่วย (ผู้ป่วยใหม่: เวลาออกคิวkiosk-เปิดสิทธิ & ผู้ป่วยเก่า:
            เวลาออกคิวkiosk-เปิดสิทธิ & ผู้ป่วยนัด: เวลาออกคิวkiosk-เปิดสิทธิ)</p>
        <div class="row">
            - ผู้ป่วยใหม่
            <div class="container-fluid">
                <div class="row">
                    จำนวนผู้ป่วยตามระยะเวลารอ
                </div>
                <div class="col">
                    <canvas id="amountwaiting_new_bar" dataname="amountwaiting_new" charttype="barchart" width="400"
                        height="400"></canvas>
                </div>
            </div>
            <div class="row">
                - ผู้ป่วยเก่า ไม่มีนัด
                <div class="container-fluid">
                    <div class="row">
                        จำนวนผู้ป่วยตามระยะเวลารอ
                    </div>
                    <div class="col">
                        <canvas id="amountwaiting_old_bar" dataname="amountwaiting_old" charttype="barchart" width="400"
                            height="400"></canvas>
                    </div>
                </div>
                <div class="row">
                    - ผู้ป่วยเก่า มีนัด
                    <div class="container-fluid">
                        <div class="row">
                            จำนวนผู้ป่วยตามระยะเวลารอ
                        </div>
                        <div class="col">
                            <canvas id="amountwaiting_appointment_bar" dataname="amountwaiting_appointment"
                                charttype="barchart" width="400" height="400"></canvas>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>