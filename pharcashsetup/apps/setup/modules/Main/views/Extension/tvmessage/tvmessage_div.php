<div id="tvmessage_div" class="container-fluid">
    <div class="row">
        <div style="width: 29rem;">
            <div class="form-group">
                <span>จอทีวีข้อความ หมายเหตุ</span>
                <?php if( $Data['TVMessage'] ) : ?>
                <form tvmessage style="display:flex;" method="post" action="./update_tvmessage/<?=$Data['TVMessage']->uid;?>">
                    <input name="message" type="text" class="form-control" value="<?= $Data['TVMessage']->message; ?>">
                    <div>
                        <i loading_spin class="fa fa-spinner fa-spin fa-3x fa-fw" style="display:none;z-index: 9; color: rgb(46, 98, 98); font-size: 1rem;"></i>
                    </div>
                </form>
                <?php else: ?>
                    <a href="./add_tvmessage/<?=$tvmessage['groupprocessuid'];?>/<?=$tvmessage['queuelocationuid'];?>">เพิ่มข้อความหมายเหตุ</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>