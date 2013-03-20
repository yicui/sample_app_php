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
        assignmenttitle:$(this).parent().parent().prev("h3").text(), 
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
  // Loadmore paginator  
  $(".loadmorepaginator").click(function() {
    var url = $(this).attr("href").split('?')[0];
    var param = $(this).attr("href").split('?')[1];
    var accordioncount = $(".accordion").children("div").length;
    $.ajax({ 
      url:url, 
      data:{coursenumber:param.split('=')[1], startingfrom:accordioncount, recordcount:2}, 
      success:function(html) {
        $(".accordion").append($(html).filter(".accordion").children());  destroywidgets();  initializewidgets();
        // Open the first of the newly-loaded accordion content
        var newcount = $(".accordion").children("div").length;
        if ((newcount - accordioncount) <= 0) return;
        $(".accordion").accordion("option", "active", accordioncount);
        if ((newcount - accordioncount) < 2) $(this).hide();
        accordioncount = newcount;
      }
    });
    return false;
  });
  // Tab-based paginator
  var tabs = $(".tabpaginator").tabs({
    load:function() { // Slidedown effect as visual cue to the new content
      initializewidgets();  $(".accordion").hide();  $(".accordion").slideDown();
    },
    active: 1, disabled: [0], // Make '1' the initial landing tab, and disable the 'Prev' tab
    beforeActivate:function(event, ui) {
      var numChildren = tabs.children("ul").children("li").length
      if (ui.newTab.index() == 0) { // 'Prev' tab
        tabs.tabs("option", "active", Math.max(ui.oldTab.index()-1, 1));
        return false;
      }
      else if (ui.newTab.index() == numChildren-1) { // 'Next' tab
        tabs.tabs("option", "active", Math.min(ui.oldTab.index()+1, numChildren-2));
        return false;
      }
      // Enable/disable the 'Prev' and 'Next' tabs according to the switching of tabs
      if (ui.newTab.index() == 1 && ui.newTab.index() == numChildren-2) {
        tabs.tabs("disable", 0);  tabs.tabs("disable", numChildren-1); 
      }
      else if (ui.newTab.index() == 1) { 
        tabs.tabs("disable", 0);  tabs.tabs("enable", numChildren-1); 
      }
      else if (ui.newTab.index() == numChildren-2) {
        tabs.tabs("enable", 0);  tabs.tabs("disable", numChildren-1); 
      }
      $(".accordion").hide(); // jQuery Tabs automatically caches content. So we hide old tabs to avoid the flashy effect 
    }
  });
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