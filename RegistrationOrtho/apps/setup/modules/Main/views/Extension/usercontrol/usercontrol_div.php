<div id="usercontrol_div" class="container-fluid">

    <div class="row">
        <div class="col-3">
            <p><button type="button" class="btn btn_pmk btn-sm" add_usercontrol><i class="fa fa-plus"></i></button>User</p>
        </div>
        <div class="col-3">
            <p><button type="button" class="btn btn_pmk btn-sm" add_usercontrol><i class="fa fa-plus"></i></button>สถานที่ห้องยา</p>
        </div>
    </div>
    <div class="row">
        <div class="container-fluid">
        <?php foreach ($Data['CurrentAuth'] as $currentkey => $currentvalue) : ?>
            <form usercontrol class="form-horizontal" method="post" action="./update_usercontrol/<?=$currentvalue->uid;?>">
            <div class="row">
                <div class="col-3">
                    <div class="row">
                        <div class="col">
                            <select class="form-control" name="username">
                                <option value=""></option>
                                <?php foreach($Data['AllUser'] as $userkey => $uservalue) : ?>
                                    <option value="<?=$uservalue->username;?>" <?=$uservalue->username == $currentvalue->username?'selected':'';?>><?=$uservalue->username;?></option>
                                <?php endforeach;?>
                                <option value="pharmacy.root" <?='pharmacy.root' == $currentvalue->username?'selected':'';?>>fix:pharmacy.root</option>
                            </select>
                        </div>
                        <div style="width: fit-content;">
                            <button type="button" class="btn btn_pmk btn-sm" remove_usercontrol="<?=$currentvalue->uid;?>"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="row">
                        <div class="col">
                            <select class="form-control" name="queuelocationuid">
                                <option value=""></option>
                                <?php foreach($Data['Queuelocation'] as $locationkey => $locationvalue) : ?>
                                <option value="<?=$locationvalue->locationuid;?>" <?=$locationvalue->locationuid == $currentvalue->queuelocationuid ?'selected':'';?>><?=$locationvalue->locationname_th;?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div style="width: fit-content;">
                            <button type="button" class="btn btn_pmk btn-sm" remove_usercontrol="<?=$currentvalue->uid;?>"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        <?php endforeach; ?>
        </div>
    </div>

</div>