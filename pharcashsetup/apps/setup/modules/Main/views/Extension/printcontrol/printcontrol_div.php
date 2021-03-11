<div id="printcontrol_div" class="container-fluid">
    <?php if( count($Data['PrintControl']) > 0 ) : ?>
    <?php foreach($Data['PrintControl'] as $key => $value): ?>
        <div class="row">
            <form printcontrol style="display: flex;" method="post" action="./update_printcontrol/<?=$value->uid;?>">            
                <div class="col form-group" style="font-family: cs_prajad_b;font-size: 18px;">
                    <span class="float-left" style="margin-right:1rem;">Print <?=$value->printcontroldesc;?></span>
                    <input type="radio" name="active" value="Y" <?=$value->active == 'Y'?'checked="checked"':'';?>>เปิด
                    <input type="radio" name="active" value="N" <?=$value->active == 'N'?'checked="checked"':'';?>>ปิด
                </div>
                <div>
                    <i loading_spin class="fa fa-spinner fa-spin fa-3x fa-fw" style="display:none;z-index: 9; color: rgb(46, 98, 98); font-size: 1rem;"></i>
                </div> 
            </form>
        </div>
    <?php endforeach; ?>
    <?php else: ?>
        <a href="./add_printcontrol/<?=$PrintControl['groupprocessuid'];?>/<?=$PrintControl['queuelocationuid'];?>">เพิ่มเปิด/ปิดการ Print</a>
    <?php endif; ?>
</div>