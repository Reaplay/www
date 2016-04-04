<div class="alert alert-danger margin-bottom-30"><!-- DANGER -->
	<strong>Внимание</strong> Страница в тестовом режиме<br />
	Сначала добавляем вопросы, а лишь потом варианты ответов!
</div>

<form action="action_admin.php?module=poll_admin&action=step3" method="post" class="block-review-content">
<input type="hidden" name = "subject" value="{$subject}">
{foreach from=$data_question item=question name=foo}

		<ul class="list-unstyled">
		<li class="text-muted">
			<label><span class="width-100 inline-block">Вопрос:</span> <strong class="text-warning">{$question}</strong></label>
			<input type="hidden" name = "question[{$smarty.foreach.foo.iteration}]" value="{$question}">
		</li>
		<li class="text-muted">
			<label><span class="width-100 inline-block">Добавить ответы:</span> <input type="text" id="c_a_{$smarty.foreach.foo.iteration}" name="howq" size="2"> <button class="btn btn-3d btn-reveal btn-teal btn-xs" onclick="return add_new_str({$smarty.foreach.foo.iteration});" target.onclick="#">Click</button></label>
		</li>
		<li>
			<ul>
				 
		
			</ul>
		</li>
		<li class="text-muted">
			<label><span class="width-100 inline-block">Ответы:</span> </label>
		</li>
		<li>
			<ul  id="table_answer_{$smarty.foreach.foo.iteration}">
				
			</ul>
		</li>
		
	</ul>
	 <br />
	 
{/foreach}
	 
     
	
	<button class="btn btn-3d btn-sm btn-reveal btn-teal" onclick="return add_new_str('num');" target.onclick="#">
		Добавить вопросы
	</button>
	<button class="btn btn-3d btn-sm btn-reveal btn-teal">
		<i class="fa fa-check"></i>
		<span>Продолжить</span>
	</button>
</form>


{literal}<script type="text/javascript">



function add_new_str(num){
var total = 0;
var i = 0;
var input_val = $( "#c_a_"+num ).val();
//alert(input_val);
while(i<input_val){
 
   total++;
  
   i++;
   $('<input>')
   .attr('type','text')
   .attr('name','answer['+num+'][]')
   .attr('class','form-control')
   .attr('placeholder','Вариант ответа')

     /*  .append(
        $('<td>')
        .css({width:'60px'})
        .append(
           $('<span id="progress_'+total+'" class="padding5px"><a href="#" onclick="$(\'#tr_image_'+total+'\').remove();" class="ico_delete"><img src="delete.png" alt="del" border="0"></a></span>')
         )
     )*/
     .appendTo('#table_answer_'+num); 
}
return false;
}

</script>{/literal}