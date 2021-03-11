<div class="container">
    <div class="row" style="text-align: center">
        <div class="col" style="margin: 5px;">
            คัดกรอง <span style="padding: 5px;background-color: #aae5ef;"> จำนวนคัดกรอง <?= $data['count']; ?> คน </span>
        </div>
    </div>
    <hr>
    <div class="container-fluid" style="max-width:600px;">
        <div class="row">
            <p>อัตราส่วนผู้ป่วย</p>
            <canvas id="type_pie" dataname="type" charttype="piechart" width="400" height="400"></canvas>
        </div>
        <hr>
        <div class="row">
            <p>อัตราส่วนสิทธิการรักษา</p>
            <canvas id="payor_pie" dataname="payor" charttype="piechart" width="400" height="400"></canvas>
        </div>
        <hr>
        <div class="row">
            <p>อัตราส่วนประเภทการรับบริการ</p>
            <canvas id="worklistgroup_pie" dataname="worklistgroup" charttype="piechart" width="400" height="400"></canvas>
        </div>
        <hr>
        <div class="row">
            <p>ผู้ป่วยตามช่วงเวลา</p>
            <canvas id="amount_bar" dataname="amount" charttype="barchart" width="400" height="400"></canvas>
        </div>
        <hr>
        <div class="row">
            <p>จำนวนผู้ป่วยตามระยะเวลารอ</p>
            <canvas id="amountwaiting_bar" dataname="amountwaiting" charttype="barchart" width="400" height="400"></canvas>
        </div>
        <hr>
        <div class="row">
            <p>สถิติการส่งห้องตรวจ</p>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>รหัสห้องตรวจ</th>
                        <th>ห้องตรวจ</th>
                        <th>ยอดรวม (คน)(เรียงจากมากไปน้อย)</th>
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