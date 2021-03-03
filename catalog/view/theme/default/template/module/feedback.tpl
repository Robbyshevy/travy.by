<div class="box">
  <div class="box-heading"><?php echo $heading_title; ?></div>
  <div class="box-content">
      <div id="feedback">
      <form  enctype="multipart/form-data">
        <div class="content">
            <b><?php echo $entry_name; ?></b><br />
            <input type="text" name="name_ajax" id="name_ajax" value="" />
            <br />
            <span class="error" id="error_name"></span>
            <br />
            <b><?php echo $entry_email; ?></b><br />
            <input type="text" name="email_ajax" id="email_ajax" value="" />
            <br />
            <span class="error" id="error_email"></span>
            <br />
            <b><?php echo $entry_enquiry; ?></b><br />
            <textarea name="enquiry_ajax" id="enquiry_ajax" cols="40" rows="10" style="width: 99%;"></textarea>
            <br />
            <span class="error" id="error_enquiry"></span>
        </div>
        <div class="button-form"><input type="button" value="<?php echo $button_post; ?>" class="button" id="feedback_ajax" /></div>
      </form>
      </div>
  </div>
</div>
<script type="text/javascript"><!--
$("#feedback #feedback_ajax").click(function(){
    var flag1=flag2=flag3=resS=0;
    var name_j = $("#name_ajax").val();
    var email_j = $("#email_ajax").val();
    var enquiry_j = $("#enquiry_ajax").val();
    var regV = /[-0-9a-z_\.]+@[-0-9a-z_]+?\.[a-zA-Z]{2,6}/;
    resS = email_j.search(regV);
    
    if(name_j.length > 3 && name_j.length < 32) flag1++;
    if(resS == 0) flag2++;
    if(enquiry_j.length > 10 && enquiry_j.length < 3000) flag3++;
    
    if(flag1==0)
        $("#error_name").text("<?=$error_name?>");
    else 
        $("#error_name").text("");
        
    if(flag2==0)
        $("#error_email").text("<?=$error_email?>");
    else 
        $("#error_email").text("");
        
    if(flag3==0)
        $("#error_enquiry").text("<?=$error_enquiry?>");
    else 
        $("#error_enquiry").text("");
    
    if(flag1==1 && flag2==1 && flag3==1){
        $.post(
            "<?=$action?>",
            {name: name_j, email: email_j, enquiry: enquiry_j},
            function(data){
                if(data == "post"){
                    $("#feedback #name_ajax, #feedback #email_ajax, #feedback #enquiry_ajax").val("");
                    $('#notification').html('<div class="success" ><span><?php echo $text_message; ?></span><img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');
				    $('.success').fadeIn('slow');
         	        $('html, body').animate({ scrollTop: 0 }, 'slow'); 
                }
            }
        );
    }
});
//--></script>