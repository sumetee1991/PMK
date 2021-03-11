<style type="text/css">
   .btn_pmk{
    color: #fff;
    /*background-color: #31527f;*/
    background: linear-gradient(90deg, rgba(36,56,109,1) 0%, rgba(47,87,126,1) 100%);
    border-color: #31527f;
    border-radius: 17px !important;
 }
 .border-left-pmk {
  border-left: .25rem solid #31527f!important;
}
.nav_pmk{

   background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(46,98,98,1) 51%, rgba(46,98,98,1) 100%);
}
.btn_edit{
   font-family:Mitr_light;
   font-size:16px;
}

.btn_pmk{
  color: #fff;
  /*background-color: #31527f;*/
  background: linear-gradient(90deg, rgba(36,56,109,1) 0%, rgba(47,87,126,1) 100%);
  border-color: #31527f;
  border-radius: 17px !important;
}
.border-left-pmk {
 border-left: .25rem solid #31527f!important;
}
.nav_pmk{

   background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(46,98,98,1) 51%, rgba(46,98,98,1) 100%);
}
.btn_edit{
   font-family:Mitr_light;
   font-size:16px;
}

ul.inline{
  margin: 0;
  padding: 0;
}
ul,ul.inline > li{
  display: inline;
}

ul.seperate_bd > li{
  border-left: 1px solid RGBA(255,255,255,1);
  padding-left: 0.5rem;
}
ul.seperate_bd > li:first-child{
  border-left: none;
}
ul.seperate_box li{
  background-color: #156a6c;
  padding: 5px;
  border-radius: 5px;
  -moz-border-radius: 5px;
  -webkit-border-radius: 5px;
  color: #fff;
  font-size: 15px;
} 
.dropdown-item{
font-size: 15px !important;
}
#dropdownMenuButton{
   background-color: #156a6c !important;
   color:#fff;
      border: 1px solid #2e6262;

}

</style>
<nav class="navbar navbar-expand navbar-light nav_pmk topbar mb-2 static-top shadow">
   <div style="font-family: Mitr; color:#fff;font-size: 25px;">
      Setup
   </div>
   <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
    <i class="fa fa-bars"></i>
 </button>

 <ul class="navbar-nav ml-auto">

   <ul class="inline seperate_box" style="font-size: 1.5rem;font-weight: 200;">
    <li id="li_serviceUnitAbbreviation"><img style="width: 26px" src="<?=base_url('static/Icon/');?>5.png" alt=""><span id="span_serviceUnitAbbreviation">Service Unit</span></li>    
    <li id="li_login" class="dropdown"><img style="width: 26px;margin-right: 4px; margin-left: 4px;" src="<?=base_url('static/Icon/');?>6.png" alt="">
     <button class="dropdown-toggle none" style="color:#FFFFFF" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <span id="span_Login">Username</span>
   </button>
   <div class="dropdown-menu" style="font-size:1.5rem;" aria-labelledby="dropdownMenuButton">
      <a id="acc_logout" class="dropdown-item" href="#">Logout</a>         
   </div>
</li>
</ul>
</nav>
<i id="loading" class="fa fa-spinner fa-spin fa-3x fa-fw" style="position: absolute;left: 40%;top: 40%;display: block; z-index: 9; color:#2e6262;font-size: 100px;"></i>