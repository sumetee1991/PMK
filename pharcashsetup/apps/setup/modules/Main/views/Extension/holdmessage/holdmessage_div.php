<div id="holdmessage_div" class="container-fluid">

    <div class="row">
        <div class="col-3">
            <span>ข้อความ Hold</span><br>
            <button type="button" class="btn btn_pmk btn-sm" add_holdmessage="<?=$holdmessage['groupprocessuid'];?><?=(isset($holdmessage['queuelocationuid'])&&$holdmessage['queuelocationuid'])?"/{$holdmessage['queuelocationuid']}":"";?>"><i class="fa fa-plus"></i></button>
        </div>
    </div>
    <div class="row">
        <?php foreach ($Data['CurrentHoldMessage'] as $currentkey => $currentvalue) : ?>
            <div style="display: flex;">
                <form holdmessage class="float-left" method="post" action="./update_holdmessage/<?=$currentvalue->uid;?>">
                    <div style="position:relative">
                        <input name="description" class="form-control" value="<?= $currentvalue->description; ?>" <?=$currentvalue->locked?'disabled':'';?>>
                        <i loading_spin class="fa fa-spinner fa-spin fa-3x fa-fw" style="position:absolute;top:0.5rem;right:0;display:none;z-index: 9; color: rgb(46, 98, 98); font-size: 1rem;"></i>
                    </div>
                </form>
                <div style="width: fit-content;">
                    <button type="button" class="btn btn_pmk btn-sm" remove_holdmessage="<?=$currentvalue->uid;?>" <?=$currentvalue->locked?'disabled':'';?>><i class="fa fa-minus"></i></button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</div>