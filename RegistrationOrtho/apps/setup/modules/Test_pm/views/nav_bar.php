  <style type="text/css">
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
  } 
</style>




<nav class="navbar navbar-expand-lg navbar-light navbar-laravel" style="background-color: #ccc;">
 <div class="container">
  <a class="navbar-brand" href="#">PMK</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
   <span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!--  <ul class="navbar-nav ml-auto">
           <li class="nav-item">
             <a class="nav-link" href="#" style="font-family:Mitr;font-weight: 300;font-size: 16px;">xxx</a>
          </li>
          <li class="nav-item">
             <a class="nav-link" href="#" style="font-family:Mitr;font-weight: 300;font-size: 16px;">xxxx</a>
          </li>
       </ul> -->
    </div>

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
</div>
</nav>