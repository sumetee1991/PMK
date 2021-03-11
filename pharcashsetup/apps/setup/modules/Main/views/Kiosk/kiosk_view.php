
<div class="container-fluid">
    <div class="row">
        <div class="col-8 mb-2"></div>
        <div class="col">
            <select name="queuelocationuid" id="select_queuelocation" class="form-control patient_type_data" style="font-family: cs_prajad_b;font-size: 18px;">
                <?php foreach ($Data['Queuelocation'] as $key => $value) : ?>
                    <option value="<?= $value->locationuid; ?>" <?=$value->locationuid == $Data['thisQueuelocation']->locationuid?'selected':'';?>><?= $value->locationname_th; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <form kiosk class="form-horizontal" method="post" action="./update_kiosk_queuelocation/<?=$Data['thisQueuelocation']->locationuid;?>">
                <div class="form-group" style="font-family: cs_prajad_b;font-size: 18px;">
                    <div class="row">
                        <div class="col">
                            ข้อความPopup 
                            <textarea name="popup_message" class="form-control"><?=$Data['KioskRow']->popup_message;?></textarea>
                        </div>                        
                        <div class="float-left">
                            <br>
                            <i loading_spin class="fa fa-spinner fa-spin fa-3x fa-fw" style="display:none;z-index: 9; color: rgb(46, 98, 98); font-size: 1.5rem;"></i>
                        </div>
                    </div>
                </div>                
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <?php if($Data['Ticket']): ?>
            <form kiosk_ticket class="form-horizontal" method="post" action="./update_kiosk_ticket">
                <div class="form-group" style="font-family: cs_prajad_b;font-size: 18px;">
                    <div class="row">
                        <div class="col">
                            ข้อความบัตรคิว 
                            <input type="hidden" name="uid" id="input_uid" value="<?=$Data['Ticket']->uid;?>">
                            <textarea name="display_message" class="form-control"><?=$Data['Ticket']->display_message;?></textarea>
                        </div>                        
                        <div class="float-left">
                            <br>
                            <i loading_spin class="fa fa-spinner fa-spin fa-3x fa-fw" style="display:none;z-index: 9; color: rgb(46, 98, 98); font-size: 1.5rem;"></i>
                        </div>
                    </div>
                </div>                
            </form>
            <?php else: ?>
            <form kiosk_ticket class="form-horizontal" method="post" action="./add_ticket_message">
                <div class="form-group" style="font-family: cs_prajad_b;font-size: 18px;">
                    <div class="row">
                        <div class="col">
                            ข้อความบัตรคิว 
                            <input type="hidden" name="purpose" id="input_purpose" value="1">
                            <input type="hidden" name="queuelocationuid" id="input_queuelocationuid" value="<?=$Data['thisQueuelocation']->locationuid;?>">
                            <textarea name="display_message" class="form-control"></textarea>
                        </div>                        
                        <div class="float-left">
                            <br>
                            <i loading_spin class="fa fa-spinner fa-spin fa-3x fa-fw" style="display:none;z-index: 9; color: rgb(46, 98, 98); font-size: 1.5rem;"></i>
                        </div>
                    </div>
                </div>                
            </form>
            <?php endif; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <form kiosk class="form-horizontal" method="post" action="./update_kiosk_queuelocation/<?=$Data['thisQueuelocation']->locationuid;?>">
                <div class="form-group" style="font-family: cs_prajad_b;font-size: 18px;">
                    <div class="row">
                        <div style="width:fit-content">
                            Kiosk                 
                            <input type="radio" name="active" value="Y" <?=$Data['KioskRow']->active == 'Y'?'checked':'';?>>เปิด
                            <input type="radio" name="active" value="N" <?=$Data['KioskRow']->active == 'N'?'checked':'';?>>ปิด
                        </div>
                        <div>
                            <i loading_spin class="fa fa-spinner fa-spin fa-3x fa-fw" style="display:none;z-index: 9; color: rgb(46, 98, 98); font-size: 1rem;"></i>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <form kiosk class="form-horizontal" method="post" action="./update_kiosk_queuelocation/<?=$Data['thisQueuelocation']->locationuid;?>">
                <div class="form-group" style="font-family: cs_prajad_b;font-size: 18px;">
                    <div class="row">
                        <div style="width:fit-content">
                            ต้องการปริ๊นต์ กรณีเลือกไม่มียาหรือไม่                 
                            <input type="radio" name="printnodrug" value="Y" <?=$Data['KioskRow']->printnodrug == 'Y'?'checked':'';?>>เปิด
                            <input type="radio" name="printnodrug" value="N" <?=$Data['KioskRow']->printnodrug == 'N'?'checked':'';?>>ปิด
                        </div>
                        <div>
                            <i loading_spin class="fa fa-spinner fa-spin fa-3x fa-fw" style="display:none;z-index: 9; color: rgb(46, 98, 98); font-size: 1rem;"></i>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
</div>