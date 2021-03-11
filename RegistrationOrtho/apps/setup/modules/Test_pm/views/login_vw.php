  
<link href="https://fonts.googleapis.com/css?family=Mitr:300&display=swap&subset=thai" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Mitr:500&display=swap&subset=thai" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Mitr:400&display=swap&subset=thai" rel="stylesheet"> 

<style type="text/css">
 .modal.fade .modal-dialog.modal-dialog-zoom {
   -webkit-transform: translate(0,0)scale(.5);
   transform: translate(0,0)scale(.5);
}
.modal.show .modal-dialog.modal-dialog-zoom {
   -webkit-transform: translate(0,0)scale(1);
   transform: translate(0,0)scale(1);}

}

      /*@import url(https://fonts.googleapis.com/css?family=Raleway:300,400,600);*/
      body{
       margin: 0;
       font-size: .9rem;
       font-weight: 400;
       line-height: 1.6;
       color: #212529;
       text-align: left;
       background-color: #fff;
       font-family: Mitr !important;
    }

     .navbar-laravel
     {
        box-shadow: 0 2px 4px rgba(0,0,0,.04);
     }

     .navbar-brand , .nav-link, .my-form, .login-form
     {
        font-family: Mitr, sans-serif;
     }

     .my-form
     {
        padding-top: 1.5rem;
        padding-bottom: 1.5rem;
     }

     .my-form .row
     {
        margin-left: 0;
        margin-right: 0;
     }

     .login-form
     {
        padding-top: 1.5rem;
        padding-bottom: 1.5rem;
     }

     .login-form .row
     {
        margin-left: 0;
        margin-right: 0;
     }
  </style>
  <nav class="navbar navbar-expand-lg navbar-light navbar-laravel">
     <div class="container">
       <a class="navbar-brand" href="#">Set Up</a>
       <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
         <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
         <ul class="navbar-nav ml-auto">
           <li class="nav-item">
             <a class="nav-link" href="#" style="font-family:Mitr;font-weight: 300;font-size: 16px;">Login</a>
          </li>
          <li class="nav-item">
             <a class="nav-link" href="#" style="font-family:Mitr;font-weight: 300;font-size: 16px;">Register</a>
          </li>
       </ul>
    </div>
 </div>
</nav>

<main class="login-form">
  <div class="cotainer">
   <form role="form" method="post" action="<?php echo base_url('member/login_member'); ?>">
    <div class="row justify-content-center">
      <div class="col-md-6">
         <div class="card">
          <!-- <div class="card-header">เข้าสู่ระบบ</div> -->
          <div class="card-body">
           <div style="font-family:Mitr;font-weight: 500;font-size: 20px;">Login</div>
           <div style="font-family:Mitr;font-weight: 300;font-size: 20px;">Set UP</div>

           <div class="form-group row">
             <label for="email_address" class="col-md-4 col-form-label text-md-right" style="font-family:Mitr;font-weight: 500;font-size: 20px;">ชื่อผู้ใช้</label>
             <div class="col-md-6">
               <input type="text" id="email_address" class="form-control" name="user_email" required autofocus style="font-family:Mitr;font-weight: 300;font-size: 15px;" placeholder="Username">
            </div>
         </div>

         <div class="form-group row">
          <label for="password" class="col-md-4 col-form-label text-md-right" style="font-family:Mitr;font-weight: 500;font-size: 20px;">รหัสผ่าน</label>
          <div class="col-md-6">
            <input type="password" id="password" class="form-control" name="user_password" required style="font-family:Mitr;font-weight: 300;font-size: 15px;" placeholder="ระบุรหัสผ่าน">
         </div>
      </div>

      <div class="form-group row">
       <div class="col-md-6 offset-md-4">
         <div class="checkbox">
           <label>
             <input type="checkbox" name="remember"> จำรหัสผ่าน
          </label>
       </div>
    </div>
 </div>

 <div class="col-md-6 offset-md-4">
   <button type="submit" class="btn btn-primary" type="submit" value="login" name="login" style="font-family:Mitr;font-weight: 400;font-size: 16px;">
      เข้าสู่ระบบ
   </button>
 
  </div>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
</main>