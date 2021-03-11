<div id="navigatemessage_div" class="container-fluid">
    <div class="row">
        <div class="col-3">
            <span>ขั้นตอนการเข้ารับบริการ</span><br>
        </div>
    </div>
    <?php if( count($Data['CurrentNavigateMessage']) >= 2 ) : ?>
    <?php foreach ($Data['CurrentNavigateMessage'] as $currentkey => $currentvalue) : ?>
        <div class="row">
            <div style="width: 1rem;">
                <?= $currentvalue->sequence + 1; ?>
            </div>
            <div class="width: 28rem;">
                <form navigatemessage style="display:flex;" method="post" action="./update_navigatemessage/<?=$currentvalue->uid;?>">
                    <div class="col form-group" style="font-family: cs_prajad_b;font-size: 18px;">
                        <input name="message" type="text" class="form-control" value="<?= $currentvalue->message; ?>">
                    </div>
                    <div class="col form-group" style="font-family: cs_prajad_b;font-size: 18px;">
                        <input name="message_description" type="text" class="form-control" value="<?= $currentvalue->message_description; ?>">
                    </div>
                    <div style="width:fit-content">
                        <i loading_spin class="fa fa-spinner fa-spin fa-3x fa-fw" style="display:none;z-index: 9; color: rgb(46, 98, 98); font-size: 1rem;"></i>
                    </div>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
    <?php else: ?>
        <a href="./add_navigatemessage/<?=$navigatemessage['groupprocessuid'];?>/<?=$navigatemessage['queuelocationuid'];?>">เพิ่มขั้นตอนการเข้ารับบริการ</a>
    <?php endif; ?>
</div>