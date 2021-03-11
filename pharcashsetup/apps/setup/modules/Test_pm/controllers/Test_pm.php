<?php

class Test_pm extends MY_Controller
{
   public function __construct()
   {

      parent::__construct();
      $this->load->helper('url');
      $this->load->helper('assets');
   }

   public function index()
   {
      $this->load->module('Template_Module');

      $Template = array(
         'Module' => 'Test_pm',
         'Site_Title' => 'test monk',
         'Content' => array(
            'test1' => 'Test_pm_vw',
         ),
         'Script' => array(
            'testscript' => 'Test_vw_script',
         ),
         'css' => array(
            'bootstrap4.3.1' => 'bootstrap/css/bootstrap.min.css',
            'fontawesome5.11.2' => 'fontawesome/css/all.css',
            'admincss' => 'css/sb-admin-2.min.css',
            'stylesheet' => 'css/style.css',

         ),
         'js' => array(
            'popper1' => 'js/popper.min.js',
            'jquery3.4.1' => 'js/jquery-3.4.1.min.js',
            'bootstrapjs' => 'bootstrap/js/bootstrap.js',
            'jsrsasign8.0.12' => 'jsrsasign/jsrsasign-all-min.js',
            'axios0.19.0' => 'axios/axios.min.js',
            'jquery-ui' => 'js/jquery-ui.js',
         ),
      );
      $this->template_module->MainTemplate($Template);
   }
   public function counter_data()
   {
      $this->load->model('Counter');
      $data = $this->Counter->get_counter();
      echo json_encode($data);
   }

   public function get_groupprocess()
   {
      $this->load->model('Counter');
      $data = $this->Counter->get_groupprocess();
      echo json_encode($data);
   }


   public function message_data()
   {
      $this->load->model('Counter');
      $data = $this->Counter->get_message();
      echo json_encode($data);
   }

   public function payor_data()
   {
      $this->load->model('Counter');
      $data = $this->Counter->get_payor_data();
      echo json_encode($data);
   }

   public function update_counter($id)
   {

      date_default_timezone_set('Asia/Bangkok');
      $data = array(
         'countername' => $this->input->post('counter_name'),
         'groupprocessuid' => $this->input->post('groupprocess'),
         'active' => $this->input->post('active'),
         'mwhen' => date('Y-m-d h:i:s'),
         'muser' => '1',
         'cuser' => '1',
      );

      $this->db->where('uid', $id);
      $result = $this->db->update('tb_counter', $data);
      $msg['success'] = false;
      if ($result) {
         $msg['success'] = true;
      }
      echo json_encode($msg);
   }


   public function process()
   {
      $this->load->module('Template_Module');

      $Template = array(
         'Module' => 'Test_pm',
         'Site_Title' => 'test monk',
         'Content' => array(
            'test1' => 'process_vw',
         ),
         'Script' => array(
            'testscript' => 'process_vw_script',
         ),
         'css' => array(
            'bootstrap4.3.1' => 'bootstrap/css/bootstrap.min.css',
            'fontawesome5.11.2' => 'fontawesome/css/all.css',
            'admincss' => 'css/sb-admin-2.min.css',
            'stylesheet' => 'css/style.css',
         ),
         'js' => array(
            'popper1' => 'js/popper.min.js',
            'jquery3.4.1' => 'js/jquery-3.4.1.min.js',
            'bootstrapjs' => 'bootstrap/js/bootstrap.js',
            'jsrsasign8.0.12' => 'jsrsasign/jsrsasign-all-min.js',
            'axios0.19.0' => 'axios/axios.min.js',
            'jquery-ui' => 'js/jquery-ui.js',
         ),
      );
      $this->template_module->MainTemplate($Template);
   }


   public function login()
   {
      $this->load->module('Template_Module');

      $Template = array(
         'Module' => 'Test_pm',
         'Site_Title' => 'test monk',
         'Content' => array(
            'test1' => 'login_vw',
         ),
         'Script' => array(
            'testscript' => 'login_vw_script',
         ),
         'css' => array(
            'bootstrap4.3.1' => 'bootstrap/css/bootstrap.min.css',
            'fontawesome5.11.2' => 'fontawesome/css/all.css',
            'admincss' => 'css/sb-admin-2.min.css',
            'stylesheet' => 'css/style.css',

         ),
         'js' => array(
            'popper1' => 'js/popper.min.js',
            'jquery3.4.1' => 'js/jquery-3.4.1.min.js',
            'bootstrapjs' => 'bootstrap/js/bootstrap.js',
            'jsrsasign8.0.12' => 'jsrsasign/jsrsasign-all-min.js',
            'axios0.19.0' => 'axios/axios.min.js',
         ),
      );
      $this->template_module->MainTemplate($Template);
   }


   public function add_patient_type()
   {
      $this->load->model('Counter');
      $data = array(
         'code' => $this->input->post('code'),
         'name' => $this->input->post('name'),
         // 'active'=>$this->input->post('active'),
         // 'cwhen'=>date('Y-m-d h:i:s'),
      );
      // var_dump($data);
      // exit();
      $result = $this->Counter->add_patient_type($data);
      echo json_decode($result);
   }






   public function add_counter()
   {
      $this->load->model('Counter');
      $data = array(
         'countername' => $this->input->post('counter_name'),
         'groupprocessuid' => $this->input->post('groupprocess'),
         'active' => $this->input->post('active'),
         'cuser' => '1',
         'cwhen' => date('Y-m-d h:i:s'),
         'mwhen' => date('Y-m-d h:i:s'),
         'muser' => '1',
      );
      // var_dump($data);
      // exit();
      $result = $this->Counter->add_counter($data);
      echo json_decode($result);
   }

   public function add_message()
   {
      $this->load->model('Counter');
      $data = array(
         'code' => $this->input->post('code'),
         'description' => $this->input->post('description'),

         // 'active'=>$this->input->post('active'),
         // 'groupprocessuid'=>'1',
      );
      // var_dump($data);
      // exit();
      $result = $this->Counter->add_message($data);
      echo json_decode($result);
   }



   public function add_groupprocess()
   {
      $this->load->model('Counter');
      $data = array(
         'name' => $this->input->post('counter_name'),
         // 'active'=>$this->input->post('active'),
         // 'cwhen'=>date('Y-m-d h:i:s'),
      );
      // var_dump($data);
      // exit();
      $result = $this->Counter->add_groupprocess($data);
      echo json_decode($result);
   }

   public function add_queue_category()
   {
      $this->load->model('Counter');
      $data = array(
         'counter' => $this->input->post('counter'),
         'active' => $this->input->post('active'), //active status
         'code' => $this->input->post('code'),
         'name' => $this->input->post('name'),
         'description' => $this->input->post('description'),
         'groupprocessuid' => $this->input->post('groupprocess'),
         'cwhen' => date('Y-m-d'),
         'cuser' => '1',
         'mwhen' => date('Y-m-d'),
         // 'active'=>$this->input->post('active'),
         // 'cwhen'=>date('Y-m-d h:i:s'),
      );

      $payorid = $this->input->post('payorid');
      $patient_type_data = $this->input->post('patient_type_data');
      // var_dump($data);
      // exit();
      $result = $this->Counter->add_queue_category($data, $payorid, $patient_type_data);
      echo json_decode($result);
   }

   public function add_payor()
   {
      $this->load->model('Counter');
      $data = array(
         'code' => $this->input->post('code'),
         'name' => $this->input->post('name'),
         'shortname' => $this->input->post('shortname'),
         'hiscode' => $this->input->post('hiscode'),
         'openactive' => 'Y',
         'active' => 'Y',
         'cuser' => '1',
         'cwhen' => date('Y-m-d h:i:s'),
         'mwhen' => date('Y-m-d h:i:s'),
         'muser' => '1',
      );
      // var_dump($data);
      // exit();
      $result = $this->Counter->add_payor($data);
      echo json_decode($result);
   }
   public function update_payor($id)
   {
      $data = array(
         'code' => $this->input->post('code'),
         'name' => $this->input->post('name'),
         'shortname' => $this->input->post('shortname'),
         'hiscode' => $this->input->post('hiscode'),
         'openactive' => $this->input->post('open_active'),
         'active' => $this->input->post('active'),
      );
      $this->db->where('uid', $id);
      $result = $this->db->update('tb_payor', $data);
      $msg['success'] = false;
      if ($result) {
         $msg['success'] = true;
      }
      echo json_encode($msg);
   }

   public function update_groupprocess($id)
   {
      $data = array(
         'name' => $this->input->post('counter_name'),
      );

      $this->db->where('uid', $id);
      $result = $this->db->update('tb_groupprocess', $data);
      $msg['success'] = false;
      if ($result) {
         $msg['success'] = true;
      }
      echo json_encode($msg);
   }

   public function update_message($id)
   {
      $data = array(
         'code' => $this->input->post('code'),
         'description' => $this->input->post('description'),
         'groupprocessuid' => $this->input->post('groupprocess'),
         'active' => $this->input->post('active'),

      );

      $this->db->where('uid', $id);
      $result = $this->db->update('tb_message', $data);
      $msg['success'] = false;
      if ($result) {
         $msg['success'] = true;
      }
      echo json_encode($msg);
   }


   public function update_category($id)
   {

      $this->db->trans_start();
      $data = array(
         'counter' => $this->input->post('counter_edit'),
         'active' => $this->input->post('active_edit'), //active status
         'code' => $this->input->post('code_edit'),
         'name' => $this->input->post('name_edit'),
         'groupprocessuid' => $this->input->post('groupprocess'),
         'cwhen' => date('Y-m-d'),
         'cuser' => '1',
         'mwhen' => date('Y-m-d'),
      );
      $this->db->where('uid', $id);
      $result = $this->db->update('tb_queuecategory', $data);
      $payorid = count($_POST['payorid']['payorid']);

      // var_dump($payorid);
      // exit();

      $total_data = array();
      for ($i = 0; $i < count($_POST['detailuid']['detailuid']); $i++) {
         $data_detail = array(
            'key' => $i,
            'payoruid' => $_POST['payorid']['payorid'][$i],
            'patienttypeuid' => $_POST['patient_type_data']['patient_type_data'][$i],
            'queuecategoryuid' => $id,
         );
         foreach ($total_data as $key => $value) {
            if (($value['payoruid'] == $data_detail['payoruid'] && $value['patienttypeuid'] == $data_detail['patienttypeuid'] && $value['queuecategoryuid'] == $data_detail['queuecategoryuid'])) {
               $data_detail = NULL;
               break;
            }
         }
         if ($data_detail != NULL) {
            array_push($total_data, $data_detail);
         }
      }
      $unique_data = array_unique($total_data, SORT_REGULAR);
      foreach ($unique_data as $key => $value) {
         $catuid = $_POST['detailuid']['detailuid'][$value['key']];
         if ($catuid == "" || $catuid == null) {
            $data_detail = array(
               'payoruid' => $value['payoruid'],
               'patienttypeuid' => $value['patienttypeuid'],
               'queuecategoryuid' => $value['queuecategoryuid'],
            );
            $result = $this->db->insert('tb_queuecategorydetail', $data_detail);
         } else {
            if ($_POST['chk']['chk'][$value['key']] == "" || $_POST['chk']['chk'][$value['key']] == null) {
               $data_detail = array(
                  'payoruid' => $value['payoruid'],
                  'patienttypeuid' => $value['patienttypeuid'],
               );
               $this->db->where('uid', $catuid);
               $result = $this->db->update('tb_queuecategorydetail', $data_detail);
            } else {
               $this->db->where('uid', $_POST['chk']['chk'][$value['key']]);
               $result = $this->db->delete('tb_queuecategorydetail');
            }
         }

         $msg['success'] = false;
         if ($result) {
            $msg['success'] = true;
         }
         echo json_encode($msg);

         $this->db->trans_complete();
      }
   }

   public function update_pateint_type($id)
   {
      $data = array(
         'code' => $this->input->post('code'),
         'name' => $this->input->post('name'),
         'shortname' => $this->input->post('shortname'),

      );

      $this->db->where('uid', $id);
      $result = $this->db->update('tb_patienttype', $data);
      $msg['success'] = false;
      if ($result) {
         $msg['success'] = true;
      }
      echo json_encode($msg);
   }



   public function delete_message()
   {
      $product_code = $this->input->post('product_code');
      $this->db->where('uid', $product_code);
      $result = $this->db->delete('tb_message');

      $msg['success'] = false;
      if ($result) {
         $msg['success'] = true;
      }
      echo json_encode($msg);
   }

   public function delete_payor()
   {
      $product_code = $this->input->post('product_code');
      $this->db->where('uid', $product_code);
      $result = $this->db->delete('tb_payor');

      $msg['success'] = false;
      if ($result) {
         $msg['success'] = true;
      }
      echo json_encode($msg);
   }

   public function delete_patient_type()
   {
      $product_code = $this->input->post('product_code');
      $this->db->where('uid', $product_code);
      $result = $this->db->delete('tb_patienttype');

      $msg['success'] = false;
      if ($result) {
         $msg['success'] = true;
      }
      echo json_encode($msg);
   }


   public function delete_counter()
   {
      $product_code = $this->input->post('product_code');
      $this->db->where('uid', $product_code);
      $result = $this->db->delete('tb_counter');

      $msg['success'] = false;
      if ($result) {
         $msg['success'] = true;
      }
      echo json_encode($msg);
   }

   public function delete_groupprocess()
   {
      $product_code = $this->input->post('product_code');
      $this->db->where('uid', $product_code);
      $result = $this->db->delete('tb_groupprocess');

      $msg['success'] = false;
      if ($result) {
         $msg['success'] = true;
      }
      echo json_encode($msg);
   }

   public function message()
   {
      $this->load->module('Template_Module');

      $Template = array(
         'Module' => 'Test_pm',
         'Site_Title' => 'test monk',
         'Content' => array(
            'test1' => 'message_vw',
         ),
         'Script' => array(
            'testscript' => 'message_vw_script',
         ),
         'css' => array(
            'bootstrap4.3.1' => 'bootstrap/css/bootstrap.min.css',
            'fontawesome5.11.2' => 'fontawesome/css/all.css',
            'admincss' => 'css/sb-admin-2.min.css',
            'stylesheet' => 'css/style.css',
         ),
         'js' => array(
            'popper1' => 'js/popper.min.js',
            'jquery3.4.1' => 'js/jquery-3.4.1.min.js',
            'bootstrapjs' => 'bootstrap/js/bootstrap.js',
            'jsrsasign8.0.12' => 'jsrsasign/jsrsasign-all-min.js',
            'axios0.19.0' => 'axios/axios.min.js',
            'jquery-ui' => 'js/jquery-ui.js',
         ),
      );
      $this->template_module->MainTemplate($Template);
   }


   public function patient()
   {
      $this->load->module('Template_Module');

      $Template = array(
         'Module' => 'Test_pm',
         'Site_Title' => 'test monk',
         'Content' => array(
            'test1' => 'patient_vw',
         ),
         'Script' => array(
            'testscript' => 'patient_vw_script',
         ),
         'css' => array(
            'bootstrap4.3.1' => 'bootstrap/css/bootstrap.min.css',
            'fontawesome5.11.2' => 'fontawesome/css/all.css',
            'admincss' => 'css/sb-admin-2.min.css',
            'stylesheet' => 'css/style.css',
         ),
         'js' => array(
            'popper1' => 'js/popper.min.js',
            'jquery3.4.1' => 'js/jquery-3.4.1.min.js',
            'bootstrapjs' => 'bootstrap/js/bootstrap.js',
            'jsrsasign8.0.12' => 'jsrsasign/jsrsasign-all-min.js',
            'axios0.19.0' => 'axios/axios.min.js',
            'jquery-ui' => 'js/jquery-ui.js',
         ),
      );
      $this->template_module->MainTemplate($Template);
   }


   public function payor()
   {
      $this->load->module('Template_Module');

      $Template = array(
         'Module' => 'Test_pm',
         'Site_Title' => 'test monk',
         'Content' => array(
            'test1' => 'payor_vw',
         ),
         'Script' => array(
            'testscript' => 'payor_vw_script',
         ),
         'css' => array(
            'bootstrap4.3.1' => 'bootstrap/css/bootstrap.min.css',
            'fontawesome5.11.2' => 'fontawesome/css/all.css',
            'admincss' => 'css/sb-admin-2.min.css',
            'stylesheet' => 'css/style.css',
         ),
         'js' => array(
            'popper1' => 'js/popper.min.js',
            'jquery3.4.1' => 'js/jquery-3.4.1.min.js',
            'bootstrapjs' => 'bootstrap/js/bootstrap.js',
            'jsrsasign8.0.12' => 'jsrsasign/jsrsasign-all-min.js',
            'axios0.19.0' => 'axios/axios.min.js',
            'jquery-ui' => 'js/jquery-ui.js',
         ),
      );
      $this->template_module->MainTemplate($Template);
   }


   public function queue_category()
   {
      $this->load->module('Template_Module');

      $Template = array(
         'Module' => 'Test_pm',
         'Site_Title' => 'test monk',
         'Content' => array(
            'test1' => 'queue_category_vw',
         ),
         'Script' => array(
            'testscript' => 'queue_category_vw_script',
         ),
         'css' => array(
            'bootstrap4.3.1' => 'bootstrap/css/bootstrap.min.css',
            'fontawesome5.11.2' => 'fontawesome/css/all.css',
            'admincss' => 'css/sb-admin-2.min.css',
            'stylesheet' => 'css/style.css',
         ),
         'js' => array(
            'popper1' => 'js/popper.min.js',
            'jquery3.4.1' => 'js/jquery-3.4.1.min.js',
            'bootstrapjs' => 'bootstrap/js/bootstrap.js',
            'jsrsasign8.0.12' => 'jsrsasign/jsrsasign-all-min.js',
            'axios0.19.0' => 'axios/axios.min.js',
            'jquery-ui' => 'js/jquery-ui.js',
         ),
      );
      $this->template_module->MainTemplate($Template);
   }



   public function patient_type_data()
   {
      $this->load->model('Counter');
      $data = $this->Counter->get_patient_data();
      echo json_encode($data);
   }


   public function queue_category_data_list($id)
   {
      $this->load->model('Counter');
      $data = $this->Counter->get_queue_category_list($id);
      echo json_encode($data);
   }




   public function queue_category_data()
   {
      $this->load->model('Counter');
      $data = $this->Counter->get_queue_category();
      echo json_encode($data);
   }

   public function delete_queue_category()
   {
      $product_code = $this->input->post('product_code');
      $this->db->where('uid', $product_code);
      $result = $this->db->delete('tb_queuecategory');


      $this->db->where('queuecategoryuid', $product_code);
      $result = $this->db->delete('tb_queuecategorydetail');


      $msg['success'] = false;
      if ($result) {
         $msg['success'] = true;
      }
      echo json_encode($msg);
   }
   public function get_catgory_detail($id)
   {
      $this->load->model('Counter');
      $data = $this->Counter->get_catgory_detail($id);
      echo json_encode($data);
   }


   public function building()
   {
      $this->load->module('Template_Module');

      $Template = array(
         'Module' => 'Test_pm',
         'Site_Title' => 'test monk',
         'Content' => array(
            'test1' => 'building_vw',
         ),
         'Script' => array(
            'testscript' => 'building_vw_script',
         ),
         'css' => array(
            'bootstrap4.3.1' => 'bootstrap/css/bootstrap.min.css',
            'fontawesome5.11.2' => 'fontawesome/css/all.css',
            'admincss' => 'css/sb-admin-2.min.css',
            'stylesheet' => 'css/style.css',
         ),
         'js' => array(
            'popper1' => 'js/popper.min.js',
            'jquery3.4.1' => 'js/jquery-3.4.1.min.js',
            'bootstrapjs' => 'bootstrap/js/bootstrap.js',
            'jsrsasign8.0.12' => 'jsrsasign/jsrsasign-all-min.js',
            'axios0.19.0' => 'axios/axios.min.js',
            'jquery-ui' => 'js/jquery-ui.js',
         ),
      );
      $this->template_module->MainTemplate($Template);
   }



   public function clinic_data()
   {
      $this->load->model('Counter');
      $data = $this->Counter->get_clinic_data();
      echo json_encode($data);
   }



   public function building_data()
   {
      $this->load->model('Counter');
      $data = $this->Counter->get_building_data();
      echo json_encode($data);
   }

   public function update_message_sort($id, $sort)
   {
      $data = array(
         'order' => $sort,
      );
      $this->db->where('uid', $id);
      $result = $this->db->update('tb_message', $data);
   }



   public function update_patient_sort($id, $sort)
   {
      $data = array(
         'order' => $sort,
      );

      $this->db->where('uid', $id);
      $result = $this->db->update('tb_patienttype', $data);
   }

   public function update_process_sort($id, $sort)
   {
      $data = array(
         'order' => $sort,
      );

      $this->db->where('uid', $id);
      $result = $this->db->update('tb_groupprocess', $data);
   }



   public function update_clinic_sort($id, $sort)
   {
      $data = array(
         'order' => $sort,
      );

      $this->db->where('uid', $id);
      $result = $this->db->update('tb_opdclinic', $data);
   }





   public function update_building_sort($id, $sort)
   {
      $data = array(
         'order' => $sort,
      );

      $this->db->where('uid', $id);
      $result = $this->db->update('tb_building', $data);
   }


   public function update_sort($id, $sort)
   {
      $data = array(
         'order' => $sort,
      );

      $this->db->where('uid', $id);
      $result = $this->db->update('tb_queuecategory', $data);
   }


   public function update_payor_sort($id, $sort)
   {
      $data = array(
         'order' => $sort,
      );
      $this->db->where('uid', $id);
      $result = $this->db->update('tb_payor', $data);
   }



   public function update_counter_sort($id, $sort)
   {
      // exit();
      $data = array(
         'order' => $sort,
      );

      $this->db->where('uid', $id);
      $result = $this->db->update('tb_counter', $data);
   }


   public function update_building($id)
   {

      date_default_timezone_set('Asia/Bangkok');
      $floor_delete = count($_POST['remove_floor']['remove_floor']);

      // var_dump($floor);
      // exit();
      for ($i = 0; $i < $floor_delete; $i++) {
         $floor_delete = $_POST['remove_floor']['remove_floor'][$i];


         $this->db->where('uid', $floor_delete);
         $result = $this->db->delete('tb_floor');
         // echo $floor_delete;

      }
      // exit();
      $data = array(
         'building_name' => $this->input->post('building_name'),
         'active' => $this->input->post('active'),
         'mwhen' => date('Y-m-d h:i:s'),
         'muser' => '1',
         'cuser' => '1',
      );

      $this->db->where('uid', $id);
      $result = $this->db->update('tb_building', $data);

      // add floor
      $floor = count($_POST['floor']['floor']);
      for ($i = 0; $i < $floor; $i++) {

         //    $number = $this->max_floor_num($id);
         //    $number = $number[0];
         //    $number = implode(", ", $number);
         //    $number = $number + 1;

         $data_floor = array(
            'buildinguid' => $id,
            'floor_number' => $_POST['floor']['floor'][$i],
            'active' => 'Y',
            'cwhen' => date('Y-m-d h:i:s'),
            'mwhen' => date('Y-m-d h:i:s'),
            'muser' => '1',
            'cuser' => '1',
         );

         $this->db->where('uid', $id);
         $result = $this->db->insert('tb_floor', $data_floor);
      }

      $msg['success'] = false;
      if ($result) {
         $msg['success'] = true;
      }
      echo json_encode($msg);
   }



   public function max_floor_num($id)
   {
      $query = "select max(floor_number) from tb_floor where buildinguid=$id";
      $code = $this->db->query($query)->result_array();
      return $code;
   }


   public function add_building()
   {

      $this->load->model('Counter');
      $data = array(
         // 'code'=>$this->input->post('building_code'),
         'building_name' => $this->input->post('building_name'),
         'cwhen' => date('Y-m-d h:i:s'),
         'cuser' => '1',
         'active' => 'Y',

      );

      $result = $this->Counter->add_building($data);

      if ($this->db->affected_rows() > 0) {
         $id = $this->db->insert_id();

         $floor = count($_POST['floor']['floor']);

         // var_dump($floor);
         // exit();
         $j = 1;

         for ($i = 0; $i < $floor; $i++) {
            $data_floor = array(
               'buildinguid' => $id,
               'floor_number' => $j,
               'cwhen' => date('Y-m-d h:i:s'),
               'cuser' => '1',
               'active' => 'Y',
               'mwhen' => date('Y-m-d h:i:s'),
               'muser' => '1',
            );
            $result = $this->Counter->add_floor($data_floor);
            $j++;
         }




         echo json_decode($result);
         return true;
      } else {
         return false;
      }
   }


   public function add_clinic()
   {
      date_default_timezone_set('Asia/Bangkok');
      $this->load->model('Counter');
      $active_date = '{' . implode(',', $this->input->post('active_date')) . '}';
      $data = array(
         'code' => $this->input->post('code'),
         'detail' => $this->input->post('detail'),
         'buildinguid' => $this->input->post('building'),
         'flooruid' => $this->input->post('floor'),
         'amount' => $this->input->post('amount'),
         'clinic_code' => $this->input->post('clinic_code'),
         'visit_active' => $this->input->post('visit_active'),
         'active_date' => $active_date,
         'active' => $this->input->post('active'),
      );
      $result = $this->Counter->add_clinic($data);
      echo json_decode($result);
   }


   public function update_clinic($id)
   {

      date_default_timezone_set('Asia/Bangkok');
      $active_date = '{' . implode(',', $this->input->post('active_date')) . '}';
      // var_dump($active_date); die();
      $data = array(
         'code' => $this->input->post('code'),
         'detail' => $this->input->post('detail'),
         'buildinguid' => $this->input->post('building'),
         'flooruid' => $this->input->post('floor'),
         'amount' => $this->input->post('amount'),
         'clinic_code' => $this->input->post('clinic_code'),
         'visit_active' => $this->input->post('visit_active'),
         'active_date' => $active_date,
         'active' => $this->input->post('active'),
      );

      $this->db->where('uid', $id);
      $result = $this->db->update('tb_opdclinic', $data);
      $msg['success'] = false;
      if ($result) {
         $msg['success'] = true;
      }
      echo json_encode($msg);
   }



   public function delete_building()
   {
      $product_code = $this->input->post('product_code');
      $this->db->where('uid', $product_code);
      $result = $this->db->delete('tb_building');


      $this->db->where('buildinguid', $product_code);
      $result = $this->db->delete('tb_floor');


      $msg['success'] = false;
      if ($result) {
         $msg['success'] = true;
      }
      echo json_encode($msg);
   }



   public function delete_clinic()
   {
      $product_code = $this->input->post('product_code');
      $this->db->where('uid', $product_code);
      $result = $this->db->delete('tb_opdclinic');
      $msg['success'] = false;
      if ($result) {
         $msg['success'] = true;
      }
      echo json_encode($msg);
   }

   public function clinic()
   {
      $this->load->module('Template_Module');

      $Template = array(
         'Module' => 'Test_pm',
         'Site_Title' => 'test monk',
         'Content' => array(
            'test1' => 'clinic_vw',
         ),
         'Script' => array(
            'testscript' => 'clinic_vw_script',
         ),
         'css' => array(
            'bootstrap4.3.1' => 'bootstrap/css/bootstrap.min.css',
            'fontawesome5.11.2' => 'fontawesome/css/all.css',
            'admincss' => 'css/sb-admin-2.min.css',
            'stylesheet' => 'css/style.css',
         ),
         'js' => array(
            'popper1' => 'js/popper.min.js',
            'jquery3.4.1' => 'js/jquery-3.4.1.min.js',
            'bootstrapjs' => 'bootstrap/js/bootstrap.js',
            'jsrsasign8.0.12' => 'jsrsasign/jsrsasign-all-min.js',
            'axios0.19.0' => 'axios/axios.min.js',
            'jquery-ui' => 'js/jquery-ui.js',
         ),
      );
      $this->template_module->MainTemplate($Template);
   }



   public function get_floor_building()
   {

      $this->load->model('Counter');
      $building = $this->input->post('building');
      $building = $this->Counter->get_floor_building($building);
      if (count($building) > 0) {
         $pro_select_box = '';
         $i = 1;
         foreach ($building as $building) {
            $pro_select_box .= "<input type='checkbox' id=chk" . $i . " name='remove_floor[remove_floor][]' value=" . $building->uid . " style='display:none;'><tr  id='row_floor$i'><td>" . $building->floor_number . '</td><td><button class="btn_pmk btn_remove_floor" type="button"  id=' . $i . ' data-uid="' . $i . '">-</button></td></tr>';
            $i++;
         }


         echo json_encode($pro_select_box);
      }
   }




   public function get_floor()
   {

      $this->load->model('Counter');
      $building = $this->input->post('building');
      $building = $this->Counter->get_floor($building);

      if (count($building) > 0) {
         $pro_select_box = '';
         $pro_select_box .= '<option value="">เลือกชั้น</option>';
         foreach ($building as $building) {
            $pro_select_box .= '<option value="' . $building->uid . '">' . $building->floor_number . '</option>';
         }
         echo json_encode($pro_select_box);
      } else {
         $pro_select_box = '<option value="">ไม่พบ</option>';
         echo json_encode($pro_select_box);
      }
   }


   public function contactno()
   {
      $this->load->module('Template_Module');

      $Template = array(
         'Module' => 'Test_pm',
         'Site_Title' => 'test monk',
         'Content' => array(
            'test1' => 'contact_vw',
         ),
         'Script' => array(
            'testscript' => 'contact_vw_script',
         ),
         'css' => array(
            'bootstrap4.3.1' => 'bootstrap/css/bootstrap.min.css',
            'fontawesome5.11.2' => 'fontawesome/css/all.css',
            'admincss' => 'css/sb-admin-2.min.css',
            'stylesheet' => 'css/style.css',
         ),
         'js' => array(
            'popper1' => 'js/popper.min.js',
            'jquery3.4.1' => 'js/jquery-3.4.1.min.js',
            'bootstrapjs' => 'bootstrap/js/bootstrap.js',
            'jsrsasign8.0.12' => 'jsrsasign/jsrsasign-all-min.js',
            'axios0.19.0' => 'axios/axios.min.js',
            'jquery-ui' => 'js/jquery-ui.js',
         ),
      );
      $this->template_module->MainTemplate($Template);
   }

   public function contactno_data()
   {
      $this->load->model('Counter');
      $data = $this->Counter->get_contactno_data();
      echo json_encode($data);
   }

   public function update_allcounter($id)
   {

      $data = array(
         'allcounter' => $this->input->post('allcounter')
      );

      $this->db->where('uid', $id);
      $result = $this->db->update('tb_groupprocess', $data);

      $msg['success'] = false;
      if ($result) {
         $msg['success'] = true;
      }
      echo json_encode($msg);
   }

   public function redirect_index()
   {
      redirect(APPNAME . '/Test_pm/index');
   }

   public function report(){
      $this->load->module('Template_Module');

      $Template = array(
         'Module' => 'Test_pm',
         'Site_Title' => 'test monk',
         'Content' => array(
            'test1' => 'Report/report_vw',
         ),
         'Script' => array(
            'testscript' => 'Report/report_vw_script',
         ),
         'css' => array(
            'bootstrap4.3.1' => 'bootstrap/css/bootstrap.min.css',
            'bootstrap-datepicker' => 'bootstrap-datepicker/css/bootstrap-datepicker.min.css',
            'fontawesome5.11.2' => 'fontawesome/css/all.css',
            'admincss' => 'css/sb-admin-2.min.css',
            'stylesheet' => 'css/style.css',
         ),
         'js' => array(
            'popper1' => 'js/popper.min.js',
            'jquery3.4.1' => 'js/jquery-3.4.1.min.js',
            'bootstrapjs' => 'bootstrap/js/bootstrap.js',
            'bootstrap-datepicker' => 'bootstrap-datepicker/js/bootstrap-datepicker.min.js',
            'jqueryDataTable' => 'jquerydataTable/datatables.min.js', 
            'jsrsasign8.0.12' => 'jsrsasign/jsrsasign-all-min.js',
            'axios0.19.0' => 'axios/axios.min.js',
            'jquery-ui' => 'js/jquery-ui.js',
         ),
      );
      $this->template_module->MainTemplate($Template);

   }
   public function report_ajax(){
      $this->load->model('Counter');
      $Input = $this->input->post();      
      header( "Content-Type: application/json" );
      switch($Input['topic']){
         case 0:
            $views['Data'] = $this->Counter->getKioskReport($Input['date_from'],$Input['date_to']);
            $output['table'] = "kiosk_report";
            $output['html'] = $this->load->view('Report/ajax/kiosk',$views,TRUE);
            break;
         case 1:
            $views['Data'] = $this->Counter->getVisitReport($Input['date_from'],$Input['date_to']);
            $output['table'] = "management_visit_report";
            $output['html'] = $this->load->view('Report/ajax/visit',$views,TRUE);
            break;
         case 2:
            $views['Data'] = $this->Counter->getNewHNReport($Input['date_from'],$Input['date_to']);
            $output['table'] = "management_newhn_report";
            $output['html'] = $this->load->view('Report/ajax/newhn',$views,TRUE);
            break;
         case 3:
            $views['Data'] = $this->Counter->getRegisterReport($Input['date_from'],$Input['date_to']);
            $output['table'] = "management_register_report";
            $output['html'] = $this->load->view('Report/ajax/register',$views,TRUE);
            break;
         default:
            $output['html'] = "Please Select Valid Topic";
            break;
      }
      echo json_encode($output);      
   }
}
