function site_url(){
  return $('#site_url').data('url');
}

function base_url(){
  return $('#base_url').data('url');
}

function get_action($this){
  return $this.data('action');
}

function get_id($this){
  return $this.data('id');
}

function get_state($this){
  return $this.data('state');
}

function set_state($this, value){
  return $this.data('state', value );
}


function isChecked($this){
  if(get_state($this) == 'checked')
    return true;
  return false;
}

function isUnchecked($this){
  if(get_state($this) == 'unchecked')
    return true;
  return false;
}

function get_checked_ids($objects){
  var ids = [];
  var index = 0;
  $objects.each(function(){
   $this = $(this);
   if(get_action($this) == 'check' &&  get_state($this) == 'checked')
   {
     ids[index] = get_id($this);
     index += 1;
   }
 })
  return ids;
}

function checkIconClicked($this){
 change_check_icon($this);
}

function checkAllClicked($this, $checkIcons){
 if(isChecked($this))
 {
      //change state to unchecked and icon to unchecked icon
      uncheck($this);
       $this.find('span').text('Uncheck All');  //change the Check All to Uncheck All

       //check all $checkIcons and change their state to checked
       check_all($checkIcons);
     }
     else if(isUnchecked($this))
     {
       //change the state to checked and icon to checked
       check($this);
       $this.find('span').text('Check All');  //change the Uncheck All to Check All
      //uncheck all $checkIcons and change their state to unchecked
      uncheck_all($checkIcons);
    }
  }



  function check($this){
   set_state($this, 'checked')
   var location = base_url() + '/asset/img/cms/check.png';
   $this.find('img').attr('src', location);

 }

 function uncheck($this){
   set_state($this, 'unchecked')
   var location = base_url() + '/asset/img/cms/unchecked.png';
   $this.find('img').attr('src', location);

 }

 function check_all($objects){
  $objects.each(function(){
   $this = $(this);
   set_state($this, 'checked')
   var location = base_url() + '/asset/img/cms/check.png';
   $this.find('img').attr('src', location);
 })
}

function uncheck_all($objects){
  $objects.each(function(){
   $this = $(this);
   set_state($this, 'unchecked');
   var location = base_url() + '/asset/img/cms/unchecked.png';
   $this.find('img').attr('src', location);
 })
}

function change_check_icon($this){
  if(isChecked($this)){
   set_state($this, 'unchecked');
   var location = base_url() + '/asset/img/cms/unchecked.png';
   $this.find('img').attr('src', location);
 }
 else if(isUnchecked($this)){
   set_state($this, 'checked')
   var location = base_url() + '/asset/img/cms/check.png';
   $this.find('img').attr('src', location);

 }
 
}



function ajax_del_checked($objects){
    //get all ids of checked thumnails
    ids = { 'ids' : get_checked_ids($objects)};

    //make an ajax call to server to delete profiles
    var address = site_url() + '/cms/author_delete';
    $.post(address, ids, function(ret){
      console.log(ret);
      intepret_result(ret, $objects);
    })

  }


  function ajax_del($this){
    ids = {'ids' : get_id($this)};

     //make an ajax call to server to delete profiles
     var address = site_url() + '/cms/author_delete';
     $.post(address, ids, function(ret){
      console.log(ret);
      intepret_result(ret, $this);
    })




   }



   function intepret_result(data, node){
    var data = $.parseJSON(data);
    if(typeof(data.ids) === "string")
    {
    //caste to Array
    data.ids = new Array(data.ids);

  }

  
  
  if(data.status == 'success')
  {
    var ids = idsToString(data.ids);
    var ids_length = data.ids.length;


    if(data.action == 'delete')
    {
      // var parent_node = node.parent();
      // // parent_node.detach();
      // var ids = data.ids;
      // parent_node.each(function(){
      //   $this = $(this);
      //   for(var i = 0; i < ids.length; i++)
      //   {
      //     if(get_id($this) == ids[i])
      //     {
      //       $this.remove();
      //     }
          //   }
          // })
      show_notification('Deleted (' + ids.length + ') account of author(s) with[id(s)] : ' + ids, data.status);
    }


}
else if(data.status == 'fail')
{
  var ids = idsToString(data.failed_ids);
  var ids_length = data.failed_ids.length;

  if(data.action == 'delete')
  {
      //add notificatio to  the dome  using a slide down 
      show_notification('Failed to delete (' +  ids_length +') account of author(s) with [id(s)] : ' + ids , data.status);
    }

  }
}


function idsToString(ids){
  ids_string = ids[0]
  for(var i=1; i< ids.length; i++)
  {
    if(i >= 5)
    {
      ids_string += " ... ";
      break;


    }
    ids_string  += " , " + ids[i]
  }
  if(ids.length >= 5 )
    ids_string += ids[ids.length-1];

  return ids_string;

}


function show_notification(text, status){
  if(status == 'success')
    var back_color = 'green';
  else if(status == 'fail')
    var back_color = 'red';

  var $notification = $('.notification').css('background', back_color);
  var defaultPosition = {
    'top' : $notification.css('top'),
    'left' : $notification.css('left')
  };

  var $span = $notification.find('span');
  $span.text(text);


  var notification_width = $('.notification').innerWidth();
  var window_width = $(window).innerWidth();
  var leftPosition =  (window_width / 2) -  (notification_width / 2) ;
  $notification.animate({
    top: "0%",
    left : leftPosition
  }, 200)

  //setTime out
  window.setTimeout(function(){
    $notification.animate({
      top:  -999,
      left : defaultPosition.left
    }, 200)
  }, 3000);

}

function ajax_get_profile(id, ajax_img_loader){
  ajax_loader(ajax_img_loader);
  var address = site_url() + '/cms/get_profile';
  $.post(address, {"id": id})
  .done(function(ret){
    ajax_loader_off(ajax_img_loader);
    interpret_json(ret);
  });
}


function ajax_loader($img){
  var loader = base_url() + 'asset/img/cms/ajax2.gif';
  $img.fadeIn();
  $img.attr('src', loader);
}

function ajax_loader_off(img){
  img.removeAttr('src');

}


function interpret_json(data){
  data = $.parseJSON(data);
  if(data.status == "success"){
    if(typeof $profile === "object" && $profile.length != 0)
    {
      var profile_data = data.profile;
        //insert data into the DOM
        $profile.hide().find('p').each(function(){
          $this = $(this);
          $second_span  = $this.find('span:nth-child(2)');
          $second_span.text('');

          var identifier = $this.attr('class');
          switch(identifier){
            case 'name': 
            $second_span.text(profile_data.name);
            break;
            case 'age': 
            $second_span.text(profile_data.age);
            break;case 'sex': 
            $second_span.text(profile_data.sex);
            break;
            case 'profession': 
            $second_span.text(profile_data.profession);
            break;
            case 'in-brief': 
            $second_span.text(profile_data.in_brief);
            break;

            case 'social-networks': 
            $second_span.text(profile_data.social_networks);
            break;
          }
        })
          //show profile
          $profile.fadeIn(500);
        }
        else
          console.log('Not dom element selected. Make sure to select the target Node');
      }
      else
      {
        console.log(data + "one one");
      }
    }