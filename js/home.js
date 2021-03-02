$.ajax({
  url: "apis/api-get-posts.php",
  dataType: "JSON"
}).done(function(jData){
  jData.forEach(post => {
    //console.log(post);
   let post_dom = `<div class="listItem mt20" data-postId=${post.id}>
   <div class="postUsername">${post.name}</div>
   <div class="postDate">on ${post.date}</div>
   <div class="postMsg mt10">${post.message}</div>
   <img class="postImg mt10" src="apis/api-download.php?file=${post.image}" alt="${post.image}">`;

  if(post.user_id){
    post_dom +=`<button class="btnEditPost mt10">Edit</button></div>`
  }else{
    post_dom +=`</div>`
  }

    $("#allPostsBox").append(post_dom) 
  });
});

//Check every 6min if session has expired
setInterval(function(){ 
  $.ajax({
    url: "apis/api-check-session.php",
    dataType: "JSON"
  }).done(function(jData){
    if(jData){
      //console.log(jData)
      location.href="logout.php?token="+jData
      return
    }
  });
 }, 360000);

//Regenerate sessionID every 20min
setInterval(function(){ 
  $.ajax({
    url: "session-regenerate.php"
  });
}, 1000 * 60 * 20);

$("#formMakePost").submit(function(event) {
  event.preventDefault();
  $.ajax({
    url: "apis/api-post.php",
    method: "POST",
    data: new FormData(this),
    contentType: false,
    processData: false,
    dataType: "JSON"
  }).done(function(jData) {
    if(jData.status === 1){
      location.href="home.php"
      return
    }else if(jData.status === 0){
      $('.postbox').append(jData.message)
      return
    }
  });
});

$(document).on("click", ".btnEditPost", function() {
  var sPostId = $(this).parent().attr('data-postId');
  var sPostMsg = $(this).siblings('.postMsg').first().text();
  var editableMsg = $(this).siblings('.postMsg')

  if($(this).text()=='Save'){
    //console.log(sPostId, sPostMsg)
    $.ajax({
      url: "apis/api-edit-post.php",
      method: "POST",
      data: {sPostId, sPostMsg}
    }).done(function(){
      location.href="home.php"
      return
    })

  }

  $(this).text('Save');
  $(editableMsg).attr('contenteditable', true);
  $(editableMsg).addClass('editable')
  
});