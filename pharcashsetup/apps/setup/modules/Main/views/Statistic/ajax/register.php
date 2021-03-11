<div class="container">
    <div class="row" style="text-align: center">
        <div class="col" style="margin: 5px;">
            เปิดสิทธิ <span style="padding: 5px;background-color: #aae5ef;"> จำนวนผู้ป่วยติดต่อเปิดสิทธิ <?= $data['count']; ?> คน </span>
        </div>
    </div>
    <hr>
    <div class="container-fluid" style="max-width:600px;">
        <div class="row">
            <p>จำนวนผู้ป่วยตามประเภทคิว</p>
            <canvas id="type_pie" dataname="type" charttype="barchart" width="400" height="400"></canvas>
        </div>
        <hr>
        <div class="row">
            <p>จำนวนการทำเปิดสิทธิผู้ป่วยตามช่วงเวลา</p>
            <canvas id="amount_bar" dataname="amount" charttype="barchart" width="400" height="400"></canvas>
        </div>
        <hr>
        <div class="row">
            <p>ระยะเวลารอเปิดสิทธิ</p>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-2">
                        ผู้ป่วยใหม่
                    </div>
                    <div class="col">
                        <canvas id="amountwaiting_new_bar" dataname="amountwaiting_new" charttype="barchart" width="400" height="400"></canvas>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2">
                        ผู้ป่วยเก่า
                    </div>
                    <div class="col">
                        <canvas id="amountwaiting_old_bar" dataname="amountwaiting_old" charttype="barchart" width="400" height="400"></canvas>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2">
                        ผู้ป่วยนัด
                    </div>
                    <div class="col">
                        <canvas id="amountwaiting_appointment_bar" dataname="amountwaiting_appointment" charttype="barchart" width="400" height="400"></canvas>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

</div>