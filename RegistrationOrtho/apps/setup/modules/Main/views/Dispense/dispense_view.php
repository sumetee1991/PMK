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
    <?php 
    foreach($Ext as $Extkey => $Extvalue): 
        $this->load->view($Extvalue);
    endforeach;
    ?>
</div>