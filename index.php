<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB"
    crossorigin="anonymous">

  <title>電子化流程設計與管理</title>
</head>

<body>

<?php
require_once(__DIR__ . "/config.php");
ini_set ("soap.wsdl_cache_enabled", "0");
$client = new SoapClient($conf['EasyFlowServer']);

if($_POST){ 
    if(
        !empty($_POST['oid'])
        && !empty($_POST['uid'])
        && !empty($_POST['eid'])
    ) {

      
        // 參數設定
        $oid = $_POST['oid'];
        $uid = $_POST['uid'];
        $eid = $_POST['eid'];


        // 送到流程管理
        try{
            $procesesStr = $client->findFormOIDsOfProcess($oid);

            $proceses = explode(",", $procesesStr);
            $process = $proceses[0];
            $template = $client->getFormFieldTemplate($process);

            $form = simplexml_load_string($template);
            // 要改的地方 START ==============================================
            
            
            $form->Textbox1 = $_POST['textbox1'];
            $form->Textbox3 = $_POST['textbox3'];
            $form->Textbox5 = $_POST['textbox5'];
            $form->Textbox7 = $_POST['textbox7'];
            $form->Textbox9 = $_POST['textbox9'];
            $form->Textbox10 = $_POST['textbox10'];
            $form->Textbox12 = $_POST['textbox12'];
            $form->RadioButton13 = $_POST['checkbox1'];
            $form->RadioButton14 = $_POST['checkbox2'];
            $form->TextArea15 = $_POST['textArea15'];

            // 要改的地方 END ==============================================

            $result = $form->asXML();
            $client->invokeProcess($oid, $eid, $uid, $process, $result, "伺服器代管申請作業");
        }catch(Exception $e){
        echo $e->getMessage();
        }

    } else {
        echo "系統錯誤";
    }
    
}

?>

  <div class="container">
    <div class="py-5 text-center">
      <h2>電子化流程設計與管理</h2>
    </div>

    <div class="row">

      <div class="col-md-12 order-md-1">
        <h4 class="mb-3"></h4>
        <form class="needs-validation" method="POST" action="./index.php">
          <div class="row">
            <div class="col-md-12 mb-3">
              <label for="eid">員工編號</label>
              <input name="eid" type="text" class="form-control" id="eid" placeholder="" value="" required>
              <div class="invalid-feedback">
                員工編號 必填
              </div>
            </div>
          </div>
          
        
        <div class="row">
              <div class="col-md-12 mb-3">
                  <label for="uid">員工單位編號</label>
                  <input name="uid" type="text" class="form-control" id="uid" placeholder="" value="" required>
                  <div class="invalid-feedback">
                    員工單位編號 必填
                  </div>
                </div>
          </div>

          <div class="row">
              <div class="col-md-12 mb-3">
                  <label for="oid">流程編號</label>
                  <input name="oid" type="text" class="form-control" id="oid" placeholder="" value="" required>
                  <div class="invalid-feedback">
                    流程編號 必填
                  </div>
                </div>
          </div>

         

            <div class="row">
              <div class="col-md-6 mb-3">
                  <label for="msg">申請單位</label>
                  <input name="textbox1" type="text" class="form-control" id="textbox1" value=""  required>
                  <div class="invalid-feedback">
                    申請單位 必填
                  </div>
                </div>
               
              <div class="col-md-6 mb-3">
                  <label for="msg">申請人</label>
                  <input name="textbox3" type="text" class="form-control" id="textbox3" value=""  required>
                  <div class="invalid-feedback">
                    申請人 必填
                  </div>
              </div>
              </div>

              <div class="row">
              <div class="col-md-12 mb-3">
                  <label for="msg">分機</label>
                  <input name="textbox5" type="text" class="form-control" id="textbox5" value=""  required>
                  <div class="invalid-feedback">
                    分機必填
                  </div>
                </div>
                </div>


              <div class="row">
              <div class="col-md-12 mb-3">
                  <label for="msg">申請日期</label>
                  <input name="textbox7" type="date" class="form-control" id="textbox7" placeholder="" value=""  required>
                  <div class="invalid-feedback">
                    申請日期 必填
                  </div>
                </div>
                </div>

              <div class="row">
              <div class="col-md-5 mb-3">
                  <label for="msg">刊登時間</label>
                  <input name="textbox9" type="datetime-local" class="form-control" id="textbox9" placeholder="" value="" required>
                  <div class="invalid-feedback">
                    刊登時間 必填
                  </div>
                </div>
                <label for="msg">至</label>
              <div class="col-md-5 mb-3">
                  <label for="msg"></label>
                  <input name="textbox10" type="datetime-local" class="form-control" id="textbox10" placeholder="" value=""  required>
                  <div class="invalid-feedback">
                    刊登時間 必填
                  </div>
                </div>
                </div>

              <div class="row">
              <div class="col-md-12 mb-3">
                  <label for="msg">目的</label>
                  <input name="textbox12" type="text" class="form-control" id="textbox12" placeholder="" value="" required>
                  <div class="invalid-feedback">
                    目的 必填
                  </div>
                </div>
                </div>


              <div class="row">
              <div class="col-md-4">
                <label>申請事項</label><br/>
                <label><input name="checkbox1" type="radio" value="1" checked>Banner(1004x300像素)</label><br/>
                <label><input name="checkbox1" type="radio" value="2">跑馬燈</label><br/>
                <label><input name="checkbox1" type="radio" value="3">快速連結</label><br/>
                <label><input name="checkbox1" type="radio" value="4">網頁內容</label><br/>
                <label><input name="checkbox1" type="radio" value="5">網頁版面</label><br/>
                <label><input name="checkbox1" type="radio" value="6"><font color="red">增建帳號</font></label><br/>
                <label><input name="checkbox1" type="radio" value="7">其他</label>
                </div>
              <div class="col-md-4">
                <label>協助事項</label><br/>
                <label><input name="checkbox2" type="radio" value="1" checked>新增</label><br/>
                <label><input name="checkbox2" type="radio" value="2">修改</label><br/>
                <label><input name="checkbox2" type="radio" value="3">刪除</label><br/>
                </div>
              
              <div class="col-md-4">
                <label>申請事項說明</label><br/>
                <textarea name="textArea15" rows="10" cols="50">123</textarea>
              
              </div>
              </div>
              </div>
              </div>











          

          <hr class="mb-4">
          <button class="btn btn-primary btn-lg btn-block" type="submit">送出</button>
        </form>
      </div>
    </div>

    <footer class="my-5 pt-5 text-muted text-center text-small">
      <p class="mb-1">&copy; 2017-2018 NKUST MIS</p>
    </footer>
  </div>

  <!-- Bootstrap core JavaScript
        ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
    crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
    crossorigin="anonymous"></script>
  <script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function () {
      'use strict';

      window.addEventListener('load', function () {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');

        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function (form) {
          form.addEventListener('submit', function (event) {
            if (form.checkValidity() === false) {
              event.preventDefault();
              event.stopPropagation();
            }
            form.classList.add('was-validated');
          }, false);
        });
      }, false);
    })();
  </script>
</body>

</html>