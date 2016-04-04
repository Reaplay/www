<div class="alert alert-danger margin-bottom-30"><!-- DANGER -->
	<strong>Внимание</strong> Страница в тестовом режиме<br />
	Сначала добавляем вопросы, а лишь потом варианты ответов!
</div>

<form action="action_admin.php?module=poll_admin&action=step2" method="post" class="block-review-content">
	<div class="fancy-form">
		<i class="fa fa-newspaper-o"></i>

		<input name="subject" type="text" class="form-control" placeholder="Тема опроса" value="{$data_poll.subject}">

		<!-- tooltip - optional, bootstrap tooltip can be used instead -->
		<span class="fancy-tooltip top-left"> <!-- positions: .top-left | .top-right -->
			<em>Введите общее название опроса</em>
		</span>
	</div>
		Количество вопросов: <input type="text" id="c_q" name="howq" size="2">
	<div class="row">
		<div class="form">
			<div class="col-md-6 col-sm-6" id="table_question">

						
						
			</div>
					
		</div>
	</div>
	

	 
     
	
	<button class="btn btn-3d btn-sm btn-reveal btn-teal" onclick="return add_new_str();" target.onclick="#">
		Добавить вопросы
	</button>
	<button class="btn btn-3d btn-sm btn-reveal btn-teal">
		<i class="fa fa-check"></i>
		<span>Продолжить</span>
	</button>
</form>



<!--
<div class="container"><div class="text-center col-md-4 col-xs-12 col-md-offset-4">
									
									<div class="inline-search clearfix inline-search-404">
										<form action="" method="get" class="search">
											<input type="search" placeholder="Хотя он не работает..." id="s" name="s">
											<button type="button" class="btn btn-default">Default</button>
											
											
											<div class="clear"></div>
											
										</form>
									</div>
									
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
<input type="button" value="Добавить поле" id="add" onclick="return add_new_str('num');">
<input type="submit" value="Отправить">
</form>-->
{literal}<script type="text/javascript">



function add_new_str(){
var total = 0;
var i = 0;
var input_val = $( "#c_q" ).val();
while(i<input_val){
 
   total++;
  
   i++;
   $('<input>')
   .attr('type','text')
   .attr('name','question[]')
   .attr('class','form-control')
   .attr('placeholder','Вопрос')

     //  .append(
    //    $('<td>')
    //    .css({width:'60px'})
   //     .append(
   //        $('<span id="progress_'+total+'" class="padding5px"><a href="#" onclick="$(\'#tr_image_'+total+'\').remove();" class="ico_delete"><img src="delete.png" alt="del" border="0"></a></span>')
 //        )
 //    )
     .appendTo('#table_question'); 
}
return false;
}

</script>{/literal}