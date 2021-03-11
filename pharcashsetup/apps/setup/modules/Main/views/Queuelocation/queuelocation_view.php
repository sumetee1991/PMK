<div class="container-fluid">
    <div class="row">
        <div class="col-8 mb-2">
        </div>
        <div class="col">
        </div>
    </div>
    <div class="row" style="margin-top:10px;">
        <div style="width:fit-content;line-height: 2.5rem;">
            สถานที่ห้องยา        
        </div>
        <div class="col-3">
            <select name="queuelocationuid" id="select_queuelocation" class="form-control patient_type_data" style="font-family: cs_prajad_b;font-size: 18px;">
                <?php foreach ($Data['Queuelocation'] as $key => $value) : ?>
                    <option value="<?= $value->locationuid; ?>"><?= $value->locationname_th; ?></option>
                    <?php 


                endforeach; ?>
            </select>
        </div>
        <div class="col">
            <div class="row">
                <div style="width:fit-content;margin:0 2.5px;line-height: 2.5rem;">
                    Location ID
                </div>
                <div style="width:3rem;">
                    <input type="text" class="form-control" value="<?=$Data['LocationData']->locationuid;?>">
                </div>
            </div>
        </div>
    </div>

    <div class="row">        
        <div style="width:fit-content;margin:0 2.5px;line-height: 2.5rem;">
            <?php 
            // var_dump($Data['Queuelocation']->locationname_th);
            // var_dump ("#select_queuelocation");
            // $abc = var #select_queuelocation;
                     // if('#select_queuelocation'== "NULL"):
            echo "ท่านต้องการตั้งค่าเสียงรวมระหว่าง คิดราคายาและการเงิน หรือไม่"; 


        // }
            // if($Data['Queuelocation']->locationname_th == "NULL"){
                

          //  }
            ?>   
    
        </div>
        <div class="col" style="line-height: 2.5rem;">
            <form queuelocation_form class="form-horizontal" method="post" action="./queuelocation_update/<?=$Data['LocationData']->uid;?>">
                <input type="radio" name="soundall" value="Y" <?=$Data['LocationData']->soundall == 'Y'?'checked':'';?>>รวม
                <input type="radio" name="soundall" value="N" <?=$Data['LocationData']->soundall == 'N'?'checked':'';?>>ไม่รวม
            </form>
        </div>
    </div>
    <div class="row">        
        <div style="width:fit-content;margin:0 2.5px;line-height: 2.5rem;">
            ท่านต้องการตั้งค่าจอทีวีรวมระหว่าง คิดราคายาและการเงิน หรือไม่
        </div>
        <div class="col" style="line-height: 2.5rem;">
            <form queuelocation_form class="form-horizontal" method="post" action="./queuelocation_update/<?=$Data['LocationData']->uid;?>">
                <input type="radio" name="displayall" value="Y" <?=$Data['LocationData']->displayall == 'Y'?'checked':'';?>>รวม
                <input type="radio" name="displayall" value="N" <?=$Data['LocationData']->displayall == 'N'?'checked':'';?>>ไม่รวม
            </form>
        </div>
    </div>
    <?php if($Data['LocationData']->displayall == 'Y'): ?>
        <div displayall="Y" class="row">
            <div style="width:fit-content;margin:0 2.5px;line-height: 2.5rem;">
                ลิงค์คิดราคายาและการเงิน
            </div>
            <div class="col">
                <input type="text" class="form-control" value="<?=DASHBOARDPHARCASH."/dashboard_mix?location_id={$Data['LocationData']->locationuid}";?>">
            </div>
        </div>
        <?php else: ?>
            <div displayall="N" class="row">
                <div style="width:fit-content;margin:0 2.5px;line-height: 2.5rem;">
                    ลิงค์คิดราคายา
                </div>
                <div class="col">
                    <input type="text" class="form-control" value="<?=DASHBOARDPHARCASH."/dashboard_drugappraisal?location_id={$Data['LocationData']->locationuid}";?>">
                </div>
                <div style="width:fit-content;margin:0 2.5px;line-height: 2.5rem;">
                    ลิงค์การเงิน
                </div>
                <div class="col">
                    <input type="text" class="form-control" value="<?=DASHBOARDPHARCASH."/dashboard_cashier?location_id={$Data['LocationData']->locationuid}";?>">
                </div>
            </div>
        <?php endif; ?>
    </div>