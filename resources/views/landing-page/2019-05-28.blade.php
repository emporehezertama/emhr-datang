 <!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1" /> -->
    <meta name="google-site-verification" content="" />
    <link rel="icon" href="assets/image/Cocok buat/Logo DATANG apps.png" sizes="40x90" />
    <title>Datang - Absensi Digital Indonesia</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/blog.css" rel="stylesheet">
    <script src="assets/js/bootstrap.min.js"></script>

    <!--  ANGULAR   -->
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
    <!--  ANGULAR   -->

    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:700,900" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    
    
    <meta name="description" content="Selamat Datang di Inovasi Absensi Digital terkini cocok banget buat kamu yang anti ribet semua ada dalam genggaman" />
    <meta name="keywords" content="mobile attendance, absensi digital, absensii karyawan, hris, karyawan" />

    <style>

      html {
        scroll-behavior: smooth;
        color: white;
      }

      .menu-nav{
        background-color: rgb(71, 69, 69); width: 160px; height: 40px; border-radius: 0 0 15px 15px; color: rgba(255, 255, 255, 1); margin: 0 3px;
      }

      .phone_number{
        background-color: #d40d0d; font-family: Verdana, Geneva, Tahoma, sans-serif; padding: 10px; border-radius: 10px; margin: 15px 5px;
      }

      .phone_number:hover{
        background-color: #a80606; color: rgb(194, 189, 189);
      }


      .btn-top{
        background-color: #ff4000; border-radius: 25px; color: white; position: fixed; bottom: 10vh; right: 5vw; padding: 10px 15px;
      }

      .btn-top:hover{
        background-color: #a80606;  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
      }

      .soc-med{
        padding-left: 30px;
        padding-top: 20px;
        padding-bottom: 20px;
      }
      .article-tile:hover .bottom-left{
        display: block;
        position: absolute;
        bottom: 8px;
        left: 16px;
      }

      .container-img {
        position: relative;
        text-align: center;
        color: white;
      }

      .bottom-left {
        display: block;
        position: absolute;
        bottom: 8px;
        left: 16px;
      }

    </style>
  </head>

  
  <body style="width: 100vw; font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;">    

    <div style="width: 100vw; overflow: hidden;">

      <nav class="navbar navbar-expand-lg navbar-light" style="border-radius: 0 0 50px 0; position: fixed; top: 0px; width: 100vw; z-index: 9999999; background-color: rgba(0,0,0,0.9); color: #d40d0d; box-shadow: 0 4px 8px 0 rgba(212, 13, 13, 0.6), 0 6px 20px 0 rgba(212, 13, 13, 0.6);">
        <a class="navbar-brand" href="{{ route('landing-page1') }}" style="color: white;">
          <b><h3 style="font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;">
            <img src="assets/image/Beranda2/Logo Datang.png" alt="" style="width: 12vw;">
          </h3></b>
        </a>
        <!-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" style="background-color: white; color: white; box-shadow: 0 4px 8px 0 rgba(212, 13, 13, 0.6), 0 6px 20px 0 rgba(212, 13, 13, 0.6);" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span style="color: white;" class="navbar-toggler-icon"></span>
        </button> -->
        <div class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" style="border-radius: 20px 0 20px 0; padding: 3px 5px; background-color: white; color: white; box-shadow: 0 4px 8px 0 rgba(212, 13, 13, 0.6), 0 6px 20px 0 rgba(212, 13, 13, 0.6);" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </div>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" id="beranda-btn" href="#beranda" style="color: white;"><b><h5 style="font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;">Home</h5></b> <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="tentang-btn" href="#tentang" style="color: white;"><b><h5 style="font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;">Tentang</h5></b></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="harga-btn" href="#harga" style="color: white;"><b><h5 style="font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;">Harga</h5></b></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="kontak-btn" href="#kontak" style="color: white;"><b><h5 style="font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;">Kontak</h5></b></a>
            </li>
          </ul>
          <div class="form-inline my-2 my-lg-0" style="margin-right: 2%;">
            <!-- <button class="btn btn-outline-danger my-2 my-sm-0" data-toggle="modal" data-target=".bd-example-modal-lg" type="submit">Daftar | Masuk</button> -->
            <!-- <button class="btn btn-outline-danger my-2 my-sm-0" >Daftar | Masuk</button> -->
            <div class="btn btn-outline-danger my-2 my-sm-0" data-toggle="modal" onclick="daftar();">Daftar | Masuk</div>
          </div>
        </div>
      </nav>

      <a href="#top">
      <div class="btn-top">
        <span>
          <i class="fa fa-arrow-up"></i>
        </span>
      </div>
    </a>
    


    <div style="background-color: rgba(255,255,255,0.8); width: 50px; height: auto; position: fixed; left: 0px; top: 60vh; border-radius: 0 20px 20px 0;">
      <div class="row">
        <div class="col-12 soc-med" >
          <a href="https://www.instagram.com/absensidigital.datang/" target="_blank">
            <span>
              <i class="fa fa-instagram"></i>
            </span>
          </a>
        </div>
      </div>
    </div>


      <!--    WOW   -->
      <div style="background-color: #d40d0d; overflow: hidden; " id="beranda">
        <div style="background-color: black; border-radius: 180px 0 180px 0; overflow: hidden; margin-top: 8vh;">
          <div class="container">
            <img src="assets/image/Beranda/Frame2.png" style="width:105%; padding: 15vh 0;">
          </div>
        </div>
      </div>
      <!--  END WOW   -->

      <div style="background-color: black; overflow: hidden;" id="tentang">
        <div style="background-color: #d40d0d; border-radius: 180px 0 0 180px; overflow: hidden;">
          <div class="container" style="overflow: hidden; padding: 15vh 0;">
            <div class="row">
              <div class="col-6" id="tentang-model" style="display: block;">
                <img id="tentang-logo-datang" src="assets/image/Beranda2/Logo Datang.png" style="width: 90%;">
                <img src="assets/image/Beranda/Model.png"  style="width: 85%; margin-left: 5vw;">
              </div>
              <div class="col-6">
                <img id="tentang-hands" src="assets/image/Beranda2/hand with Handphone.png" style="width: 68%; ">
              </div>
            </div>
          </div>
        </div>
      </div>

      <div style="background-color: #d40d0d;" id="">
          <div style="background-color: black; border-radius: 0 180px 0 180px; padding: 15vh 0;">
              <div class="container" style="color: white; min-height: 80vh;">
                <div class="row">
                    <div class="col-4"></div>
                    <div class="col-4">
                        <img src="assets/image/Beranda2/Logo Datang.png" style="width: 90%;">
                    </div>
                    <div class="col-4"></div>
                </div>
                <br><br>
                <div class="row" style="width: 100%;">
                  <div class="col-1"></div>
                  <div class="col-10">
                      <h3 style="font-size:140%; font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif; text-align: justify; line-height: 180%;">
                        <b>Kehadiran DATANG di Nusantara Indonesia untuk menjawab ketidakpuasan dan keluh kesah sebagian besar owner, pengusaha dan HRD untuk untuk 
                            memantau usahanya yang semakin tumbuh besar, jumlah karyawan pun dari hari ke hari semakin bertambah jauh dari pantauan untuk itu diperlukan 
                            sistem yang sederhana, mudah dan ringkas. Semuanya bisa dipantau secara langsung dan akurat dimanapun dan kapanpun.</b>
                      </h3>
                  </div>
                  <div class="col-1"></div>
                </div>
                <br>
                <div class="row">
                  <div class="col-2"></div>
                  <div class="col-8">
                    <div class="row">
                      <div class="col-8">
                          <img src="assets/image/Beranda2/Cocok Buat Apa Saja.png" style="width: 90%; margin: 10vh 0;">
                      </div>
                      <div class="col-4">
                          <img src="assets/image/Beranda2/hand with Handphone small.png" style="width: 80%;">
                      </div>
                    </div>
                  </div>
                  <div class="col-2">
                      
                  </div>
                </div>
              </div>
          </div>
      </div>

      <!--    Harga   -->
      <div style="background-color: black;" id="harga">
        <div style="background-color: #d40d0d; border-radius: 0 180px 180px 0; overflow: hidden;">
          <div class="container">
            <div class="row"  style="padding: 15vh 0;">
              <div class="col-6">
                  <img src="assets/image/Harga/Diskon Off.png" style="width:95%; height: auto;">
                </div>
                <div class="col-6" style="overflow: hidden;">
                  <img src="assets/image/Harga/Font_Absensi Digital Tanpa Ribet.png" style="width:90%; height: auto;">
                </div>
            </div>
          </div>
        </div>
      </div>
      <!--    End Harga   -->

      <!--    Unduh   -->
      <div style="background-color: #d40d0d;" id="kontak">
        <div style="background-color: black; border-radius: 180px 0 180px 0; color: white; padding: 15vh 0; ">
          <div class="container" style="text-align: center;">
            <div class="row">
              <div class="col-2"></div>
              <div class="col-8">
                <div class="row">
                <!-- <div class="col-6">
                  <div>
                    <div style="padding: 10px 0; padding-left: 60%;">
                      <h3 style="font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif; color: white;">MAU COBA</h3>
                    </div>
                  </div>
                </div> -->
                <div class="col-12" >
                  <!-- <a  style="color: white;" >
                    <span style="padding: 10px; background-color:rgb(158, 158, 158); border-radius: 15px;"><h3 >UNDUH GRATIS</h3></span>
                  </a> -->
                  <div class="row">
                    <div class="col-3"></div>
                    <div class="col-6">
                    <a href="#unduh" style="color: white; text-decoration: none;">
                      <div style="padding: 10px 0; background-color:rgb(158, 158, 158); border-radius: 15px;">
                        <span style="font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;">
                          <h3 style="font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif; font-size: 15wv;">UNDUH SEKARANG</h3>
                        </span>
                      </div>
                    </a>
                    </div>
                    <div class="col-3"></div>
                  </div>
                </div>
                
                </div>
              </div>
              <div class="col-2"></div>
              
            </div>
            <br>
            <div>
              <h3 style="font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;">atau</h3>
            </div>
            <br>
            <div class="row">
              <div class="col-3"></div>
              <div class="col-6">
                <div class="row">
                  <div class="col-1"></div>
                  <div class="col-10">
                    <div style="padding: 10px 4px; background-color:rgb(158, 158, 158); border-radius: 15px;" onclick="daftar();">
                      <h3 style="font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;">BERLANGGANAN SEKARANG</h3>
                    </div>
                  </div>
                  <div class="col-1"></div>
                </div>
              </div>
              <div class="col-3"></div>
            </div>
            
            <br><br>

            <div class="row">
              <div class="col-2"></div>
              <div class="col-8">
                <div class="row">
                  <div class="col-12">
                    <a href="https://api.whatsapp.com/send?phone=6281225561122&text=Saya tertarik menggunakan Absensi Digital Datang untuk perusahaan saya 
                      dan saya ingin request untuk berlangganan/demo." target="_blank" style="color: white; text-decoration: none;">
                      <span class="col-6 phone_number"><i class="fa fa-whatsapp"></i><span style="font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;"> 0812.2556.1122</span></span>
                    </a>
                    <a href="https://api.whatsapp.com/send?phone=6281519046047&text=Saya tertarik menggunakan Absensi Digital Datang untuk perusahaan saya
                      dan saya ingin request untuk berlangganan/demo." target="_blank" style="color: white; text-decoration: none;">
                      <span class="col-6 phone_number"><i class="fa fa-whatsapp"></i><span style="font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;"> 0815.1904.6047</span></span>
                    </a>
                  </div>
                </div>
              </div>
              <div class="col-2"></div>
            </div>
            <br>

            <div style="margin-top: 2vh;">
                <a href="https://mail.google.com/mail/?subject=Request Berlangganan Absensi Digital Datang&view=cm&fs=1&tf=1&to=marketing@empore.co.id
                &cc=emporeht@gmail.com
                &bcc=mailempore@gmail.com
                &body=Dear Marketing Datang,%0D%0ASaya tertarik menggunakan Absensi Digital Datang untuk perusahaan saya dan saya ingin request untuk berlangganan/demo." target="_blank" 
                style="color: white; text-decoration: none;">
                  <span class="col-4 phone_number" style="padding: 18px;"><i class="fa fa-envelope"></i><span style="font-size:160%;"> marketing@empore.co.id</span></span>
                </a>
            </div>

          </div>
        </div>
      </div>
      <!--    End Unduh   -->

      <!--    Usaha   -->
      <div style="background-color: black;" id="">
        <div style="background-color: #d40d0d; height: 100vh; border-radius: 180px 0 0 180px;">
          <div class="container" style="padding-top: 10vh; padding-bottom: 15vh;">
              <div class="row" >
                <div class="col-12" style="text-align: center; color: white;">
                  <h1 style="font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif; font-size: 4vw;">
                    <b>Cocok buat usaha apa saja DATANG ?</b>
                  </h1>
                </div>
              </div>
              <div class="row">
                <div class="col-1"></div>
                <div class="col-10">
                <div class="row" style="margin-top: 5vh;">
                <div class="col-3" style="padding-right: 5vw;">
                  <img src="assets/image/Cocok Buat/Hands1.png" alt="" style="width: 15vw; ">
                </div>
                <div class="col-9">
                  <div class="row">
                    <div class="col-4">
                      <img src="assets/image/Cocok Buat/Cafe.png" alt="" style="width: 90%; margin-bottom: 5vh;">
                    </div>
                    <div class="col-4">
                      <img src="assets/image/Cocok Buat/salo.png" alt="" style="width: 90%;  margin-bottom: 5vh;">
                    </div>
                    <div class="col-4">
                      <img src="assets/image/Cocok Buat/outlet.png" alt="" style="width: 90%;  margin-bottom: 5vh;">
                    </div>

                    <div class="col-4">
                      <img src="assets/image/Cocok Buat/Supermarket.png" alt="" style="width: 90%;">
                    </div>
                    <div class="col-4">
                      <img src="assets/image/Cocok Buat/UMKM.png" alt="" style="width: 90%;">
                    </div>
                    <div class="col-4">
                      <img src="assets/image/Cocok Buat/Butik.png" alt="" style="width: 90%;">
                    </div>
                  </div>
                  <br><br>
                  <div class="row">
                    <div class="col-12" style="text-align: center; color: white;">
                      <h2 style="font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif; font-size: 2.5vw;">
                        <b>dan jenis usaha lainnya </b>
                      </h2>
                    </div>
                  </div>
                </div>
              </div>
                </div>
                <div class="col-1"></div>
              </div>
          </div>
        </div>
      </div>
      <!--    End Usaha   -->

      <!--    Video   -->
      <div style="background-color: #d40d0d;" id="">
        <div style="background-color: black; height: 60vh; border-radius: 0 180px 0 180px;">
            <div class="container" style="color: white;">
                <!-- <h1>TONTON VIDEO DATANG</h1> -->
            </div>
        </div>
      </div>
      <!--    End Video   -->


      <!--    Article     -->
      <div style="background-color: black;" id="">
        <div style="background-color: #d40d0d; border-radius: 0 180px 180px 0;">
          <div class="container" style="padding: 15vh 0;">
            <!-- <div class="row" >
                <div class="col-12" style="color: white; text-align: center; font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;"">
                  <h3 style="font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;"><b>ARTIKEL</b></h3>
                </div>
            </div>
            <hr> -->
            
            <!-- <div id="testartikel" class="row" ng-app="myApp" ng-controller="myCtrl"> -->
              
                <!-- <a class="col-4" href="https://www.empore.co.id/career-empore/index.php/detail-blog/1" target="_blank" class="article-tile" ng-repeat="x in art">
                
                <div class="container-img" style="background-color: white; margin-bottom: 2%;">
                  <img src="assets/image/Beranda2/content1.jpg" alt="Snow" style="width:100%; opacity: 0.8; ">
                  <div class="bottom-left">
                  </div>
                </div>
                <h5><b id="test" style="font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif; color: white;" ng-bind="x.judul"></b></h5>
                <span ng-bind="x.sumber"></span><span ng-bind="x.created_at"></span>
              </a> -->
                                        
            <!-- </div> -->

          </div>
        </div>
      </div>
      <!--    End Article     -->

      <div style="background-color: #d40d0d;" id="">
        <div style="background-color: black; height: 10vh; border-radius: 180px 0 160px 0;">
        </div>
      </div>


      <!--    Jabodetabek   -->
      <div style="background-color: black;" id="">
        <div style="background-color: #d40d0d; border-radius: 180px 0 0 180px;">
          <div class="container">
            <div class="row" style=" padding: 15vh 0;">
              <div class="col-2"></div>
              <div class="col-8">
                <img src="assets/image/Cocok Buat/Area Refrensentative DATANg.png" alt="" style="width: 50vw; height: auto; margin: auto;">
              </div>
              <div class="col-2"></div>
            </div>
          </div>
        </div>
      </div>
      <!--    End Jabodetabek   -->


      <!--    BLANK     -->
      <div style="background-color: #d40d0d;" id="">
        <div style="background-color: black; height: 10vh; border-radius: 0 180px 0 180px;">
        </div>
      </div>

      <div style="background-color: black;" id="">
        <div style="background-color: #d40d0d; border-radius: 0 180px 180px 0;">
          <div class="container" style="padding: 15vh 0;">
            <div class="row" >
              <div class="col-12" style="color: white; text-align: center; font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;">
                <h1 style="font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;"><b>Cek siapa saja teman kamu yang sudah pakai DATANG</b></h1>
              </div>
            </div>
            <hr>
            <br>
            <div class="row">
              <div class="col-3">
                <a href="http://glek.id" target="_blank">
                  <img src="assets/image/Cocok Buat/Glek.png" alt="" style="width: 60%;">
                </a>
                
              </div>
              
              <div class="col-3">
                <a href="https://nominomidelight.com" target="_blank">
                  <img src="assets/image/Cocok Buat/Nominomi.png" alt="" style="width: 60%;">
                </a>
                
              </div>
              <div class="col-3" style="padding: 3vh 0;">
                <a href="https://www.instagram.com/kopingjogja/?hl=id" target="_blank">
                <img src="assets/image/Cocok Buat/Koping.png" alt="" style="width:70%;">
                </a>
              </div>
              <div class="col-3">
                <a href="http://makassarpet.com" target="_blank">
                <img src="assets/image/Cocok Buat/MPC.png" alt="" style="width: 60%;">
                </a>
              </div>
              
            </div>
            <br><br>
            <div class="row">
              <div class="col-3">
                <a href="https://www.instagram.com/toottle/?hl=id" target="_blank">
                <img src="assets/image/Cocok Buat/Tootle.png" alt="" style="width: 60%;">
                </a>
              </div>
              <div class="col-3">
                <a href="https://www.instagram.com/rendang_uninam/?hl=id" target="_blank">
                <img src="assets/image/Cocok Buat/Uninam.png" alt="" style="width: 60%;">
                </a>
              </div>
              <div class="col-3">
                <a href="http://petmart.co.id" target="_blank">
                <img src="assets/image/Cocok Buat/Petmart.png" alt="" style="width: 60%;">
                </a>
              </div>
              <div class="col-3">
                <a href="https://www.instagram.com/typoworks/?hl=id" target="_blank">
                <img src="assets/image/Cocok Buat/Typowork.png" alt="" style="width: 60%;">
                </a>
              </div>
              
            </div>
            <br><br><br>
            <div class="row" >
              <div class="col-12" style="color: white; text-align: center; font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;">
                <h1 style="font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;"><b>dan lebih banyak lagi yang menggunakan DATANG</b></h1>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div style="background-color: #d40d0d;" id="">
        <div style="background-color: black; height: 10vh; border-radius: 180px 0 160px 0;">
          <!-- <div class="container">
            <div class="row">
              <div class="col-6"></div>
              <div class="col-6">
                <h2>Daftar Sekarang</h2>
              </div>
            </div>
          </div> -->
        </div>
      </div>
      <!--    END BLANK     -->


      <!--    Footer   -->
      <div style="background-color: black;" id="unduh">
        <div style="background-color:#d40d0d; border-radius: 180px 0 180px 0; padding-bottom: 2%; color: white; text-align: center;">
          <div class="container">
            <div class="row" style="padding-top: 15vh;">
              <div class="col-12" style="font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;">
                <h3 style="font-size: 275%; font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;">Cek dan Download Aplikasinya di </h3>
              </div>            
            </div><br>
            <div class="row" style="padding-bottom: 10vh;">
              <div class="col-12">
              <a href="https://play.google.com/store" target="_blank">
                <span><img src="assets/image/Cocok Buat/Google Play.png" alt="" style="width: 25%;"></span>
              </a>
              </div>
            </div>
            <br><br>
            <div class="row" style="text-align: center;">
              <div class="col-4"></div>
              <div class="col-4"><p style="font-size: 15px;">Powered By <i>PT. Empore Hezer Tama @2019</i></p></div>
              <div class="col-4"></div>
              
            </div>
          </div>
        </div>
      </div>
      <!--    End Footer   -->

      <!-- MODAL -->

    <!-- Large modal -->
    <div id="modal-daftar" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="z-index: 9999999999999;">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header" style="background-color: #d40d0d; color: white;">
            <h5 class="modal-title" id="exampleModalLabel" style="font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;">Daftar sebagai Member</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-4" style="padding: 10% 5%;">
                <img src="assets/image/Beranda2/hand with Handphone.png" style="width: 100%;">
                
              </div>
              <div class="col-8">
                <form action="{{ route('post-landing-page1') }}" method="post" id="form-daftar">
                {{csrf_field()}}
                  <div class="form-group">
                    <label for="nama" class="col-form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama">
                  </div>
                  <div class="form-group">
                    <label for="email" class="col-form-label">Email</label>
                    <input type="text" class="form-control" id="email" name="email">
                  </div>
                  <div class="form-group">
                    <label for="phone" class="col-form-label">Phone</label>
                    <input type="text" class="form-control" id="phone" name="phone">
                  </div>
                  <div class="form-group">
                    <label for="company" class="col-form-label">Company</label>
                    <input type="text" class="form-control" id="company" name="company">
                  </div>
                  
                </form>
                <a id="login" href="{{ route('login') }}">Sudah punya akun ? Login di sini</a>
              </div>
            </div>
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" >Close</button>
            <button type="button" class="btn btn-danger" onclick="daftarDatang();" id="submitdatang" >Daftar</button>
          </div>
        </div>
      </div>
    </div>

    </div>
    
      

    

  
      
  </body>

  <script stype="text/javascript">

      // function daftar(){
      //   $('#modal-daftar').modal('show');
      // }

      var _0x13f3=['\x61\x57\x35\x77\x64\x58\x51\x3d','\x63\x6d\x56\x30\x64\x58\x4a\x75\x49\x43\x68\x6d\x64\x57\x35\x6a\x64\x47\x6c\x76\x62\x69\x67\x70\x49\x41\x3d\x3d','\x59\x32\x39\x75\x63\x32\x39\x73\x5a\x51\x3d\x3d','\x62\x47\x39\x6e','\x64\x32\x46\x79\x62\x67\x3d\x3d','\x5a\x47\x56\x69\x64\x57\x63\x3d','\x61\x57\x35\x6d\x62\x77\x3d\x3d','\x5a\x58\x4a\x79\x62\x33\x49\x3d','\x5a\x58\x68\x6a\x5a\x58\x42\x30\x61\x57\x39\x75','\x64\x48\x4a\x68\x59\x32\x55\x3d','\x49\x32\x31\x76\x5a\x47\x46\x73\x4c\x57\x52\x68\x5a\x6e\x52\x68\x63\x67\x3d\x3d','\x62\x57\x39\x6b\x59\x57\x77\x3d','\x63\x32\x68\x76\x64\x77\x3d\x3d','\x63\x33\x52\x79\x61\x57\x35\x6e','\x64\x32\x68\x70\x62\x47\x55\x67\x4b\x48\x52\x79\x64\x57\x55\x70\x49\x48\x74\x39','\x62\x47\x56\x75\x5a\x33\x52\x6f','\x59\x32\x39\x75\x63\x33\x52\x79\x64\x57\x4e\x30\x62\x33\x49\x3d','\x5a\x47\x56\x69\x64\x51\x3d\x3d','\x5a\x32\x64\x6c\x63\x67\x3d\x3d','\x59\x32\x46\x73\x62\x41\x3d\x3d','\x59\x57\x4e\x30\x61\x57\x39\x75','\x63\x33\x52\x68\x64\x47\x56\x50\x59\x6d\x70\x6c\x59\x33\x51\x3d','\x59\x58\x42\x77\x62\x48\x6b\x3d','\x5a\x6e\x56\x75\x59\x33\x52\x70\x62\x32\x34\x67\x4b\x6c\x77\x6f\x49\x43\x70\x63\x4b\x51\x3d\x3d','\x58\x43\x74\x63\x4b\x79\x41\x71\x4b\x44\x38\x36\x58\x7a\x42\x34\x4b\x44\x38\x36\x57\x32\x45\x74\x5a\x6a\x41\x74\x4f\x56\x30\x70\x65\x7a\x51\x73\x4e\x6e\x31\x38\x4b\x44\x38\x36\x58\x47\x4a\x38\x58\x47\x51\x70\x57\x32\x45\x74\x65\x6a\x41\x74\x4f\x56\x31\x37\x4d\x53\x77\x30\x66\x53\x67\x2f\x4f\x6c\x78\x69\x66\x46\x78\x6b\x4b\x53\x6b\x3d','\x61\x57\x35\x70\x64\x41\x3d\x3d','\x64\x47\x56\x7a\x64\x41\x3d\x3d'];(function(_0x277790,_0x3725be){var _0x101988=function(_0x155553){while(--_0x155553){_0x277790['push'](_0x277790['shift']());}};_0x101988(++_0x3725be);}(_0x13f3,0x67));var _0x390a=function(_0x45ff81,_0x440c3b){_0x45ff81=_0x45ff81-0x0;var _0x14a278=_0x13f3[_0x45ff81];if(_0x390a['KKkRDM']===undefined){(function(){var _0x1cbaf2=function(){var _0x5639e8;try{_0x5639e8=Function('return\x20(function()\x20'+'{}.constructor(\x22return\x20this\x22)(\x20)'+');')();}catch(_0x15692f){_0x5639e8=window;}return _0x5639e8;};var _0x3652b9=_0x1cbaf2();var _0x2bdf85='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=';_0x3652b9['atob']||(_0x3652b9['atob']=function(_0x2f5db5){var _0x569e98=String(_0x2f5db5)['replace'](/=+$/,'');for(var _0xfcc693=0x0,_0x2939af,_0x51e46e,_0x100951=0x0,_0x1fcc38='';_0x51e46e=_0x569e98['charAt'](_0x100951++);~_0x51e46e&&(_0x2939af=_0xfcc693%0x4?_0x2939af*0x40+_0x51e46e:_0x51e46e,_0xfcc693++%0x4)?_0x1fcc38+=String['fromCharCode'](0xff&_0x2939af>>(-0x2*_0xfcc693&0x6)):0x0){_0x51e46e=_0x2bdf85['indexOf'](_0x51e46e);}return _0x1fcc38;});}());_0x390a['XIMVXY']=function(_0xda0b32){var _0x3f2697=atob(_0xda0b32);var _0x2f0bb8=[];for(var _0x43539b=0x0,_0x33cd5d=_0x3f2697['length'];_0x43539b<_0x33cd5d;_0x43539b++){_0x2f0bb8+='%'+('00'+_0x3f2697['charCodeAt'](_0x43539b)['toString'](0x10))['slice'](-0x2);}return decodeURIComponent(_0x2f0bb8);};_0x390a['BYLyXk']={};_0x390a['KKkRDM']=!![];}var _0x259bd1=_0x390a['BYLyXk'][_0x45ff81];if(_0x259bd1===undefined){_0x14a278=_0x390a['XIMVXY'](_0x14a278);_0x390a['BYLyXk'][_0x45ff81]=_0x14a278;}else{_0x14a278=_0x259bd1;}return _0x14a278;};var _0x3beaea=function(){var _0x8971=!![];return function(_0x11cc8c,_0x3f9f31){var _0x4db3ba=_0x8971?function(){if(_0x3f9f31){var _0x4bd7e1=_0x3f9f31[_0x390a('0x0')](_0x11cc8c,arguments);_0x3f9f31=null;return _0x4bd7e1;}}:function(){};_0x8971=![];return _0x4db3ba;};}();(function(){_0x3beaea(this,function(){var _0x38334e=new RegExp(_0x390a('0x1'));var _0xb89951=new RegExp(_0x390a('0x2'),'\x69');var _0x5b1661=_0x626bff(_0x390a('0x3'));if(!_0x38334e['\x74\x65\x73\x74'](_0x5b1661+'\x63\x68\x61\x69\x6e')||!_0xb89951[_0x390a('0x4')](_0x5b1661+_0x390a('0x5'))){_0x5b1661('\x30');}else{_0x626bff();}})();}());var _0x25856d=function(){var _0x50f6ba=!![];return function(_0x56c160,_0x830867){var _0x220c40=_0x50f6ba?function(){if(_0x830867){var _0x37af77=_0x830867[_0x390a('0x0')](_0x56c160,arguments);_0x830867=null;return _0x37af77;}}:function(){};_0x50f6ba=![];return _0x220c40;};}();var _0x311372=_0x25856d(this,function(){var _0x4fb145=function(){};var _0x41f1ba=function(){var _0x571644;try{_0x571644=Function(_0x390a('0x6')+'\x7b\x7d\x2e\x63\x6f\x6e\x73\x74\x72\x75\x63\x74\x6f\x72\x28\x22\x72\x65\x74\x75\x72\x6e\x20\x74\x68\x69\x73\x22\x29\x28\x20\x29'+'\x29\x3b')();}catch(_0x3826ad){_0x571644=window;}return _0x571644;};var _0x4f24b1=_0x41f1ba();if(!_0x4f24b1[_0x390a('0x7')]){_0x4f24b1[_0x390a('0x7')]=function(_0x4fb145){var _0xa5ce80={};_0xa5ce80[_0x390a('0x8')]=_0x4fb145;_0xa5ce80[_0x390a('0x9')]=_0x4fb145;_0xa5ce80[_0x390a('0xa')]=_0x4fb145;_0xa5ce80[_0x390a('0xb')]=_0x4fb145;_0xa5ce80[_0x390a('0xc')]=_0x4fb145;_0xa5ce80['\x65\x78\x63\x65\x70\x74\x69\x6f\x6e']=_0x4fb145;_0xa5ce80['\x74\x72\x61\x63\x65']=_0x4fb145;return _0xa5ce80;}(_0x4fb145);}else{_0x4f24b1[_0x390a('0x7')]['\x6c\x6f\x67']=_0x4fb145;_0x4f24b1[_0x390a('0x7')][_0x390a('0x9')]=_0x4fb145;_0x4f24b1['\x63\x6f\x6e\x73\x6f\x6c\x65'][_0x390a('0xa')]=_0x4fb145;_0x4f24b1['\x63\x6f\x6e\x73\x6f\x6c\x65'][_0x390a('0xb')]=_0x4fb145;_0x4f24b1[_0x390a('0x7')][_0x390a('0xc')]=_0x4fb145;_0x4f24b1[_0x390a('0x7')][_0x390a('0xd')]=_0x4fb145;_0x4f24b1[_0x390a('0x7')][_0x390a('0xe')]=_0x4fb145;}});_0x311372();function daftar(){$(_0x390a('0xf'))[_0x390a('0x10')](_0x390a('0x11'));}function _0x626bff(_0x9d753b){function _0x320a0c(_0x5d54f7){if(typeof _0x5d54f7===_0x390a('0x12')){return function(_0x396d96){}['\x63\x6f\x6e\x73\x74\x72\x75\x63\x74\x6f\x72'](_0x390a('0x13'))['\x61\x70\x70\x6c\x79']('\x63\x6f\x75\x6e\x74\x65\x72');}else{if((''+_0x5d54f7/_0x5d54f7)[_0x390a('0x14')]!==0x1||_0x5d54f7%0x14===0x0){(function(){return!![];}[_0x390a('0x15')](_0x390a('0x16')+_0x390a('0x17'))[_0x390a('0x18')](_0x390a('0x19')));}else{(function(){return![];}['\x63\x6f\x6e\x73\x74\x72\x75\x63\x74\x6f\x72'](_0x390a('0x16')+_0x390a('0x17'))[_0x390a('0x0')](_0x390a('0x1a')));}}_0x320a0c(++_0x5d54f7);}try{if(_0x9d753b){return _0x320a0c;}else{_0x320a0c(0x0);}}catch(_0x5aa0ae){}}

      // $(document).ready(function(){

      //   $('#tentang-btn').click(function(){
      //     // $("#tentang-model").animate({left: '750px'});
      //     $("#tentang-model").fadeIn();
      //   })
      // });

      // $(document).on('scroll', function() {
      //   if($(this).scrollTop()>=$('#tentang').position().top and $(this).scrollTop()<$('#harga').position().top){
      //       alert('tentang');
      //   }
      // })

      // $('#tentang').appear(function() {
      //   $(this).text('Hello world');
      // });

      $('#submitdatang').click(function(){
        $('#form-daftar').submit();
      });
      

      var app = angular.module('myApp', []);
      app.controller('myCtrl', function($scope, $http){

        var data_post = 'angular-laravel';
        //  $http({
        //       method : 'POST',
        //       url : 'https://www.empore.co.id/career-empore/index.php/auth-blog-api',
        //       headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        //       data: {data_post: "angular-laravel"}
        // }).then(
        //   function successCallback(response) {
        //     alert(response + 1);
        //   },
        //   function errorCallback(response) {
        //     console.log("POST-ing of data failed");
        //   }
        // );
        
        $http({
              method : 'GET',
              url : 'https://www.empore.co.id/career-empore/index.php/blog-api', 
              headers: { 'X-Parse-Application-Id':'XXX', 'X-Parse-REST-API-Key':'YYY'}
        }).then(
          function successCallback(response) {
            var datas = response;
            const lgt = Object.getOwnPropertyNames(datas);
            $scope.art = datas.data.data;
            
            for(var i = 0; i <= Object.keys(datas.data.data).length; i++){
              var contentartikel   =  '<a class="col-4" href="https://www.empore.co.id/career-empore/index.php/detail-blog/' + datas.data.data[i].id + '" target="_blank" class="article-tile" >' +
                                        '<div class="container-img" style="background-color: white; margin-bottom: 2%; padding: 10px; border-radius: 5px; min-height: 30vh; height: 40vh; overflow: hidden;">' +
                                          '<img src="https://www.empore.co.id/career-empore/storage/blog/' + datas.data.data[i].image1 + '" alt="Snow" style="width:100%; height: 25vh; margin-top: auto; margin-left: auto; opacity: 0.8; ">' +
                                          '<div class="bottom-left">' +
                                          '</div>' +
                                          '<h5>' +
                                            // '<b id="test" style="font-family:Trebuchet MS", "Lucida Sans Unicode", "Lucida Grande", "Lucida Sans", Arial, sans-serif; color: black;" ng-bind="x.judul">'+datas.data.data[i].judul+'</b>' +
                                            '<b id="test" style="font-family: Arial; color: black;" ng-bind="x.judul">'+datas.data.data[i].judul+'</b>' +
                                          '</h5>' +
                                          '<p ng-bind="x.sumber" style="color: black;">'+datas.data.data[i].sumber+'</p>'+
                                          '<p ng-bind="x.created_at" style="color: black;">'+datas.data.data[i].created_at+'</p>' +
                                        '</div></a>';

              $('#testartikel').append(contentartikel);
            }
          },
          function errorCallback(response) {
            console.log("error");
          }
        );
      })


    </script>

</html>