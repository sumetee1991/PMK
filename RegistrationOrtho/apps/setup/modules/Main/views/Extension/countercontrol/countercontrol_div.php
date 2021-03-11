<div id="countercontrol_div" class="container-fluid">

    <div class="row">
        <div class="col-3">
            <span>ช่องบริการ</span><br>
            <button type="button" class="btn btn_pmk btn-sm" add_countercontrol="<?=$countercontrol['groupprocessuid'];?><?=(isset($countercontrol['queuelocationuid'])&&$countercontrol['queuelocationuid'])?"/{$countercontrol['queuelocationuid']}":"";?>"><i class="fa fa-plus"></i></button>
        </div>
    </div>
    <div class="row">
        <?php foreach ($Data['CurrentCounter'] as $currentkey => $currentvalue) : ?>
            <div>
                <form countercontrol class="float-left" method="post" action="./update_countercontrol/<?=$currentvalue->uid;?>">
                    <select name="counterno" class="form-control float-left" style="width:fit-content;">
                        <option value=""></option>
                        <?php for ($counterno = 1;$counterno <= 100;$counterno++) :; ?>
                            <?php if(!in_array($counterno, $Data['OccupiedCounter']) || $counterno == $currentvalue->counterno) : ?>
                            <option value="<?= $counterno; ?>" <?= $currentvalue->counterno == $counterno?'selected':''; ?>><?= $counterno; ?></option>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </select>
                </form>
                <button type="button" class="btn btn_pmk btn-sm" remove_countercontrol="<?=$currentvalue->uid;?>"><i class="fa fa-minus"></i></button>
            </div>
        <?php endforeach; ?>
    </div>

</div>