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
  function initializewidgets(container) {
    $(container).find(".accordion").accordion();
    // Open the first of the newly-loaded accordion content
    $(container).find(".accordion").accordion("option", "active", itemCount-recordCount);
    $(container).find(".editinplace span").on("click", edit);
    $(container).find(".editinplace [value='Save']").on("click", save);
    $(container).find(".editinplace [value='Cancel']").on("click", cancel);
    $(container).find(".datepicker").datepicker({dateFormat: 'yy-mm-dd'});
  }
  function destroywidgets(container) {
    $(container).find(".accordion").accordion("destroy");
    $(container).find(".editinplace span").off("click", edit);
    $(container).find(".editinplace [value='Save']").off("click", save);
    $(container).find(".editinplace [value='Cancel']").off("click", cancel);
    $(container).find(".editinplace .datepicker").datepicker("destroy");
  }
  initializewidgets(document); 
  $(document).tooltip();  
  // Loadmore paginator  
  const recordCount = 5;
  var itemCount = recordCount;
  $(".loadmorepaginator").click(function() {
    var url = $(this).attr("href").split('?')[0];
    var param = $(this).attr("href").split('?')[1];
    var openElement = $(this).parent().prev();
    $.ajax({ 
      url:url, 
      data:{coursenumber:param.split('=')[1], startingfrom:itemCount, recordcount:recordCount},
      success:function(html) {
        if ($(html).children().length == 0) {
          openElement.next().hide();  return;
        }
        itemCount += recordCount;
        openElement.append($(html).children());  destroywidgets(openElement.parent());  initializewidgets(openElement.parent());
      }
    });
    return false;
  });
  // Tab-based paginator
  var tabs = $(".tabpaginator").tabs({
    load:function() { // Slidedown effect as visual cue to the new content
      initializewidgets($(this));  $(this).children("div").children().hide();  $(this).children("div").children().slideDown();
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
      $(this).children("div").children().hide(); // jQuery Tabs automatically caches content. So we hide old tabs to avoid the flashy effect 
    }
  });
  // Dialog for formView
  $(".dialog").click(function() {
    var openElement = $("<div></div>").load($(this).attr("href")).dialog({modal:true, width:"auto", title:$(this).text()});
    return false;
  });
  // Lightbox
  var lightboxes = {};
  $(".lightbox").each(function() {
    lightboxes[$(this).attr("href")] = $("<img/>").attr({src:$(this).attr("href"), title:$(this).attr("title")}).dialog({ autoOpen: false });
  });
  $(".lightbox").click(function() {
    lightboxes[$(this).attr("href")].dialog("open");    
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