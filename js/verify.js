$('#frmVerify').submit(function(e){
    e.preventDefault()
    $.ajax({
      url: "apis/api-activate-user.php",
      method: "POST",
      data: $('#frmVerify').serialize(),
      dataType: "JSON"
    }).always(function(jData){
      console.log(jData)
  
      if(jData.status === 1){
        $('h1').text(jData.message)
        setInterval(function(){
            location.href="login.php"
        }, 1000)
        return
      }
  
      $('h1').text(jData.message)
    })
  });