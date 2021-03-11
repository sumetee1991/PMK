<div class="container">
    <div class="row" style="text-align: center">
        <div class="col" style="margin: 5px;">
            - จำนวนคัดกรอง <span style="padding: 5px;background-color: #aae5ef;"> จำนวน <?= $data['count']; ?> คน
            </span>
        </div>
    </div>
    <hr>
    <div class="container-fluid" style="max-width:600px;">
        <p>- อัตราส่วนประเภทผู้ป่วย</p>
        <div class="row">
            <p>ประเภทผู้ป่วย</p>
            <canvas id="type_pie" dataname="type" charttype="piechart" width="400" height="400"></canvas>
        </div>
        <hr>
        <p>- อัตราส่วนสิทธิการรักษา</p>
        <div class="row">
            <p>ประภทสิทธิ</p>
            <canvas id="payor_pie" dataname="payor" charttype="piechart" width="400" height="400"></canvas>
        </div>
        <hr>
        <p>- อัตราส่วนประเภทการรับบริการ</p>
        <div class="row">
            <p>ประเภทการรับบริการ</p>
            <canvas id="worklistgroup_pie" dataname="worklistgroup" charttype="piechart" width="400"
                height="400"></canvas>
        </div>
        <hr>
        <p>- จำนวนผู้ป่วยติดต่อคัดกรองตามช่วงเวลา (ช่วงละ 1 ชั่วโมง) </p>
        <div class="row">
            <p>ผู้ป่วยตามช่วงเวลา</p>
            <canvas id="amount_bar" dataname="amount" charttype="barchart" width="400" height="400"></canvas>
        </div>
        <hr>
        <p>- ระยะเวลารอคัดกรอง (เวลา Kiosk-คัดกรอง แบบ Histogram ช่วงละ 10 นาที)</p>
        <div class="row">
            <p>จำนวนผู้ป่วยระยะเวลารอ</p>
            <canvas id="amountwaiting_bar" dataname="amountwaiting" charttype="barchart" width="400"
                height="400"></canvas>
        </div>
        <hr>
        <div class="row">
            <p>- สถิติการส่งห้องตรวจ</p>
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <th>รหัสห้องตรวจ</th>
                        <th>ห้องตรวจ</th>
                        <th>ยอดรวม (คน)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($data['cliniccount'] as $cckey => $ccvalue): ?>
                    <tr>
                        <td><?=$ccvalue['clinic_code'];?></td>
                        <td><?=$ccvalue['detail'];?></td>
                        <td><?=$ccvalue['count'];?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>