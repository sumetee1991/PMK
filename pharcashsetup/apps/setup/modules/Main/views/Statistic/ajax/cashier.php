<div class="container">
    <div class="row" style="text-align: center">
        <div class="col" style="margin: 5px;">
            - จำนวนผู้ป่วยติดต่อการเงิน <span style="padding: 5px;background-color: #aae5ef;"> จำนวน
                <?= $Data['count']; ?> คน </span>
        </div>
    </div>
    <hr>
    <br>
    <div class="container-fluid" style="max-width:600px;">
        <p> - จำนวนผู้ป่วยตามประเภทคิว</p>
        <div class="row">
            <p>ผู้ป่วยตามประเภทคิว</p>
            <canvas id="queuecate_bar" dataname="queuecate" charttype="barchart" width="400" height="400"></canvas>
            <span>หมายเหตุ:ยอดรวมของกราฟจะนับได้แต่ที่มีวันที่-เวลา ที่มีคิวเข้าการเงินเท่านั้น</span>
        </div>
        <hr>
        <br>
        <p> - อัตราส่วนสิทธิของผู้ป่วยที่ติดต่อการเงิน</p>
        <div class="row">
            <p>จำนวนผู้ป่วยที่ใช้สิทธิต่างๆ</p>
            <canvas id="credit_pie" dataname="credit" charttype="piechart" width="400" height="400"></canvas>
        </div>
        <hr>
        <br>
        <p> - ระยะเวลารอติดต่อการเงิน (เวลาคิดราคายา-กดเรียกคิวการเงินครั้งแรกแบบ Histogram ช่วงละ 10 นาที</p>
        <div class="row">
            <p>จำนวนผู้ป่วยตามระยะเวลารอ</p>
            <canvas id="amountwaiting_bar" dataname="waiting" charttype="barchart" width="400" height="400"></canvas>
            <span>เวลารอติดต่อการเงินนับตั้งแต่เวลาออกคิวคิดราคายาถึงเรียกคิวการเงินครั้งแรก</span><br>
            <span>หมายเหตุ:ยอดรวมของกราฟจะนับได้แต่ที่มีวันที่-เวลา ที่มีคิวเข้าการเงินเท่านั้น</span>
        </div>
        <hr>
        <br>
        <p> - เรียกคิวครั้งแรกตามช่วงเวลา (ช่วงละ 1 ชม.) </p>
        <div class="row">
            <p>ผู้ป่วยตามช่วงเวลา</p>
            <canvas id="amount_bar" dataname="amount" charttype="barchart" width="400" height="400"></canvas>
            <span>หมายเหตุ:ยอดรวมของกราฟจะนับได้แต่ที่มีวันที่-เวลา ที่มีคิวเข้าการเงินเท่านั้น</span>
        </div>
    </div>

</div>