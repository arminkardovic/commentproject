$(document).ready(function(){
    $('body').on('click', '.replay', function (e){
        e.preventDefault();
        var id = $(this).attr("data");
        if(typeof id !=='undefined'){
            var html = $("#temporary_form").html();
            
            html = html.replace(/id_value/g, id);

            $("#comment_form_" + id).html(html);
            $("#comment_form_" + id).slideToggle();
        }
    });
    
    $('body').on('click', '.like_b', function (e){
         e.preventDefault();
         var butt = $(this);
         var id = butt.attr("data");
         var typ = butt.attr("type-b");

            $.ajax({
                url: '/post/updatelkdsl',
                type: 'GET',
                data: { comment_id: id, islike : typ} ,
                contentType: 'application/json; charset=utf-8',
                dataType: 'json',
                success: function (res) {
                    console.log(res);
                    if (typeof res.dislike !== "undefined") {
                        $("#comm_disl_" + id).val(res.dislike);
                        $("#comm_like_" + id).val(res.like);
                        var sel = "#holder_button_" + id;
                        var parentTag = $(sel);
                        parentTag.find(".like_b").attr('disabled','disabled');
                    }
                },
                error: function () {
                     console.log("error");
                }
            });
      });
        
     $('body').on('click', '.report_b', function (e){
         e.preventDefault();
         var butt = $(this);
         var id = butt.attr("data");

            $.ajax({
                url: '/post/report_comment',
                type: 'GET',
                data: { comment_id: id} ,
                contentType: 'application/json; charset=utf-8',
                dataType: 'json',
                success: function (res) {
                    console.log(res);
                    if (typeof res.type_r !== "undefined") {
                        
                        if(res.type_r == true){
                           butt.attr('disabled','disabled');
                        } else {
                        
                        }
                    }
                },
                error: function () {
                     console.log("error");
                }
            }); 
       });
    
$('[data-toggle="popover"]').popover();

$('body').on('click', function (e) {
    $('[data-toggle="popover"]').each(function () {
        if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
            $(this).popover('hide');
        }
    });
});
    
});

function replaceAll(find, replace, str) {
  return str.replace(new RegExp(find, str), replace);
}
