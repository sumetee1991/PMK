<div class="container-fluid" style="background-color: #FFFFFF;width:60vw;max-width:60vw;height:40vh;max-height:40vh;margin:19.5vh 20vw 0vh 20vw;border-radius: 30px;padding:2% 5%;display: table;">
    <h1>Management</h1>

    <div class="container" style="vertical-align:middle;display: table-cell;">
        <h2>ไปยังจุดให้บริการ</h2>
        <div class="container-fluid">
            <div class="row btn_row">
                <a <?php /*href="<?=base_url(LOCALPATH.'/Management/Filter');?>"*/?> data-link="Filter"><button>คัดกรอง</button></a>
                <a <?php /*href="<?=base_url(LOCALPATH.'/Management/AltDashboard');?>"*/?> data-link="AltDashboard"><button>คิวทำประวัติผู้ป่วย</button></a>
                <a <?php /*href="<?=base_url(LOCALPATH.'/Management/Dashboard');?>"*/?> data-link="Dashboard"><button>คิวเปิดสิทธิ</button></a>
            </div>
        </div>
        <hr>

        <div id="filterDiv" class="div_hidden">
            <div class="container-fluid">
                <div id="filterRow" class="row">
                    <div class="colBtn" >
                        <a class="button medium block c_lightblue" href="./Filter/0" >ไปจุดให้บริการ</a>
                    </div> 
                </div>
            </div>
        <hr>
        </div>

        <div id="counterDiv" class="div_hidden">
            <h2>กรุณาเลือกช่องบริการ</h2>
            <div class="container-fluid">
                <div id="counterRow" class="row">
                    <!-- 
                        <div class="colBtn" >
                            <a class="button medium block c_lightblue" data-tabcounter="1" data-tabaction="tabcounter">1</a>
                        </div> 
                    -->
                </div>
            </div>
        <hr>
        </div>
        <?php /*
        <div class="container-fluid" style="margin:0 2.5% 2.5% 2.5%;">
            <div class="row">
                <div class="colBtn">
                    <a class="button medium block c_green" data-setup="save">บันทึก</a>
                </div>
                <!-- 
                    <div class="colBtn">
                        <a class="button medium block c_yellow" data-setup="clear">ยกเลิก</a>
                    </div> 
                -->
            </div>
        </div>
        */ ?>
    </div>
</div>