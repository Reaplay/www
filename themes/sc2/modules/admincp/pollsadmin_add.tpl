<div class="alert alert-danger margin-bottom-30"><!-- DANGER -->
	<strong>Внимание</strong> Страница в тестовом режиме
</div>
<div class="container">
    <div class="text-center col-md-4 col-xs-12 col-md-offset-4">
									<!-- INLINE SEARCH -->
									<div class="inline-search clearfix inline-search-404">
										<form action="" method="get" class="search">
											<input type="search" placeholder="Хотя он не работает..." id="s" name="s">
											<button type="button" class="btn btn-default">Default</button>
											
											
											<div class="clear"></div>
											
										</form>
									</div>
									<!-- /INLINE SEARCH -->
								</div>
	</div>
<a href="#" class="btn btn-hvr hvr-icon-float-away">Icon Float Away</a>
<table width="100%" border="1">
  <tr><td>Количество вариантов ответов: <input type="text" id="num" name="howq" size="2"></td></tr><tr><td>/td></tr></table>
  <form action="" method="post">
       <table id="table_container">
             <tr>
                    <td width="100px" colspan="2"><strong>Название</strong></td>
             </tr>
        </table>
        <br/>
<input type="button" value="Добавить поле" id="add" onclick="return add_new_image('num_q');">
<input type="submit" value="Отправить">
</form>
{literal}<script type="text/javascript">
var total = 0;
var i = 0;


function add_new_image(num_q){
var input_val = document.getElementById(num_q).value;
while(i<input_val){
 
   total++;
  
   i++;
   $('<tr>')
   .attr('id','tr_image_'+total)
   .css({lineHeight:'20px'})
   .append (
       $('<td>')
       .attr('id','td_title_'+total)
       .css({paddingRight:'5px',width:'200px'})
       .append(
           $('<input type="text" />')
           .css({width:'200px'})
           .attr('id','input_title_'+total)
           .attr('name','input_title_'+total)
       )                             
                              
    )
    .append(
        $('<td>')
        .css({width:'60px'})
        .append(
           $('<span id="progress_'+total+'" class="padding5px"><a href="#" onclick="$(\'#tr_image_'+total+'\').remove();" class="ico_delete"><img src="delete.png" alt="del" border="0"></a></span>')
         )
     )
     .appendTo('#table_container'); 
}	 
}
$(document).ready(function() {
    add_new_image();
});
</script>{/literal}