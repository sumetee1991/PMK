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
            <p>ประเภทคิว</p>
            <canvas id="type_pie" dataname="type" charttype="barchart" width="400" height="400"></canvas>
        </div>
        <div class="row">
            <p>null=มีการออกคิวที่ kiosk แต่คิวดังกล่าวไม่มีการตั้งค่าให้มีประเภทคิว</p>
        </div>
        <hr>
        <p>- เสร็จสิ้นตามช่วงเวลา (ช่วงละ 1 ชั่วโมง)</p>
        <div class="row">
            <p>จำนวนผู้ป่วยเปิดสิทธิ</p>
            <canvas id="amount_bar" dataname="amount" charttype="barchart" width="400" height="400"></canvas>
        </div>
        <hr>
        <p>- ระยะเวลารอเปิดสิทธิตามประเภทผู้ป่วย (ผู้ป่วยใหม่: ทำประวัติ-เปิดสิทธิ & ผู้ป่วยเก่า: คัดกรอง-เปิดสิทธิ &
            ผู้ป่วยนัด: kiosk-เปิดสิทธิ)</p>
        <div class="row">
            <div class="container-fluid">
                <div class="row">
                    <p>- ผู้ป่วยใหม่</p>
                </div>
                <div class="row">
                    <p>จำนวนผู้ป่วยตามระยะเวลารอ</p>
                </div>
                <div class="col">
                    <canvas id="amountwaiting_new_bar" dataname="amountwaiting_new" charttype="barchart" width="400"
                        height="400"></canvas>
                </div>
            </div>
            <div class="row">
                <div class="container-fluid">
                    <div class="row">
                        <p>- ผู้ป่วยเก่า ไม่มีนัด</p>
                    </div>
                    <div class="row">
                        <p>จำนวนผู้ป่วยตามระยะเวลารอ</p>
                    </div>
                    <div class="col">
                        <canvas id="amountwaiting_old_bar" dataname="amountwaiting_old" charttype="barchart" width="400"
                            height="400"></canvas>
                    </div>
                </div>
                <div class="row">
                    <div class="container-fluid">
                        <div class="row">
                            <p>- ผู้ป่วยเก่า มีนัด</p>
                        </div>
                        <div class="row">
                            <p>จำนวนผู้ป่วยตามระยะเวลารอ</p>
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