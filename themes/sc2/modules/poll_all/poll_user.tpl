<div class="alert alert-danger margin-bottom-30"><!-- DANGER -->
	<strong>Внимание</strong> Страница в тестовом режиме
</div>


<div class="tab-content">
	<div class="tab-pane fade in active" id="step1">
		<p>Первый шаг</p>
		<a href="#step2" data-toggle="tab" onclick="next_step('2')"><button type="button" class="btn btn-default">Дальше</button></a>
	</div>
	<div class="tab-pane fade" id="step2">
		<p>Второй</p>
		<a href="#step1" data-toggle="tab" onclick="prev_step('1')"><button type="button" class="btn btn-default">Назад</button></a>
		<a href="#step3" data-toggle="tab" onclick="next_step('3')"><button type="button" class="btn btn-default">Дальше</button></a>
	</div>
	<div class="tab-pane fade" id="step3">
		<p>Третий</p>
		<a href="#step2" data-toggle="tab" onclick="prev_step('2')"><button type="button" class="btn btn-default">Назад</button></a>
		<a href="#step4" data-toggle="tab" onclick="next_step('4')"><button type="button" class="btn btn-default">Дальше</button></a>
	</div>
	<div class="tab-pane fade" id="step4">
		<p>Четвертый.</p>
		<a href="#step3" data-toggle="tab"onclick="prev_step('3')"><button type="button" class="btn btn-default">Назад</button></a>
		<a href="#" data-toggle="tab"><button type="button" class="btn btn-default">Завершить</button></a>
	</div>
</div>

	<div class="row process-wizard process-wizard-default">

	<div class="col-xs-3 process-wizard-step active" id="mstep1">
		<div class="text-center process-wizard-stepnum">Шаг 1</div>
		<div class="progress"><div class="progress-bar"></div></div>
		<a href="#" class="process-wizard-dot"></a>
		<div class="process-wizard-info text-center">Первая часть вопросов</div>
	</div>

	<div class="col-xs-3 process-wizard-step disabled" id="mstep2"><!-- complete -->
		<div class="text-center process-wizard-stepnum">Шаг 2</div>
		<div class="progress"><div class="progress-bar"></div></div>
		<a href="#" class="process-wizard-dot"></a>
		<div class="process-wizard-info text-center">Вторая часть вопросов</div>
	</div>

	<div class="col-xs-3 process-wizard-step disabled" id="mstep3"><!-- complete -->
		<div class="text-center process-wizard-stepnum">Шаг 3</div>
		<div class="progress"><div class="progress-bar"></div></div>
		<a href="#" class="process-wizard-dot"></a>
		<div class="process-wizard-info text-center">Третья часть вопросов</div>
	</div>

	<div class="col-xs-3 process-wizard-step disabled" id="mstep4"><!-- active -->
		<div class="text-center process-wizard-stepnum">Конец</div>
		<div class="progress"><div class="progress-bar"></div></div>
		<a href="#" class="process-wizard-dot"></a>
		<div class="process-wizard-info text-center">Завершение</div>
	</div>

</div>

{literal}
	<script>
    function next_step(step){
	var next_step =  parseInt(step);
	var cur_step = next_step-1;
	
	$('div[id=mstep'+cur_step+']').attr('class', 'col-xs-3 process-wizard-step complete' );
	$('div[id=mstep'+next_step+']').attr('class', 'col-xs-3 process-wizard-step active' );
	}
	function prev_step(step){
	var prev_step =  parseInt(step);
	var cur_step = prev_step+1;
	
	$('div[id=mstep'+prev_step+']').attr('class', 'col-xs-3 process-wizard-step active' );
	$('div[id=mstep'+cur_step+']').attr('class', 'col-xs-3 process-wizard-step disable' );
	}
</script>
{/literal}
