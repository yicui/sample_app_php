$(document).ready(function(){
  // Edit in place
  function edit() {
    $(this).parent().children(":text").val($(this).text());
    $(this).parent().children().toggle();
  };
  var openText;  
  function save() {
    openText = $(this).parent().children("span");
    var url = $(this).attr("href").split('?')[0];
    var param = $(this).attr("href").split('?')[1];
    $.get(url, 
      {
        coursenumber:param.split('=')[1],
        assignmenttitle:$(this).parent().parent().parent().prev("h3").text(), 
        duedate:$(this).parent().children(":text").val()
      },
      function(data) { openText.text(data); });
    $(this).parent().children().toggle();
  };
  function cancel()  {
    $(this).parent().children().toggle();
  };
  // Accordion, date picker, and tooltip
  function initializewidgets() {
    $(".accordion").accordion();
    $(".accordion").find(".editinplace span").on("click", edit);
    $(".accordion").find(".editinplace [value='Save']").on("click", save);
    $(".accordion").find(".editinplace [value='Cancel']").on("click", cancel);
    $(".accordion").find(".editinplace .datepicker").datepicker({dateFormat: 'yy-mm-dd'});
  }
  function destroywidgets() {
    $(".accordion").accordion("destroy");
    $(".accordion").find(".editinplace span").off("click", edit);
    $(".accordion").find(".editinplace [value='Save']").off("click", save);
    $(".accordion").find(".editinplace [value='Cancel']").off("click", cancel);	
    $(".accordion").find(".editinplace .datepicker").datepicker("destroy");
  }
  initializewidgets();  
  $(document).tooltip();  
  // Lightbox
  var lightbox = $("<img/>").attr({src:$(".lightbox").attr("href"), title:$(".lightbox").attr("title")}).dialog({ autoOpen: false });
  $(".lightbox").click(function() {
    lightbox.dialog("open");    
    return false;  
  });
  // Google Map  
  var params = $("#map").attr("src").split('&');
  var addr = {"address":""};
  var zoom = {"maxZoom":10};
  for (var i = 0; i < params.length; i++) {
    var pair = params[i].split('=');
    if (pair[0] == "markers" && pair[1].split(':')[0] == "address")
      addr.address = decodeURIComponent(pair[1]).split(':')[1];
    if (pair[0] == "zoom" || pair[0] == "maxZoom") 
      zoom.maxZoom = pair[1];
  }
  $('#map').replaceWith($("<div></div>").width("400px").height("250px").css({"margin":"auto"}).gmap3({
    map:{options:zoom}, marker:addr}, "autofit" ));
});