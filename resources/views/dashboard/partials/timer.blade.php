<div class="container">

	<div id="timerDiv" class="ScheduleTimer ScheduleTimer-fixedBottom--bgWhite ScheduleTimer-fixedBottom text-center ScheduleTimer--noRadiusBottom NoDisplay">

		<a data-toggle="collapse" href="#detailsTimer">

			<ul class="ScheduleTimer-menu">
				<li class="ScheduleTimer-item">
					Tempo de Estudo
				</li>
				<li class="ScheduleTimer-item" id="studyClock">
					<span style="display:none;" class="PomodoroList-icon PomodoroList-icon--danger Icon Icon--pomodoroBefore"></span>
				</li>
				<li class="ScheduleTimer-pomodoro">


					<a href="#" id="pomodoroPause" class=" Button Button--tiny Button--default Button--defaultDanger">Parar Tempo</a>
					<a href="#" id="pomodoroPlay" class=" Button Button--tiny Button--default Button--defaultGreen" style="display: none;">Continuar</a>

				</li>
			</ul>
		</a>
		<div id="detailsTimer" class="panel-collapse collapse">
			{{-- @foreach($subjects as $subject)
			<tr>
				<td data-th="Disciplina">
					<span class="Widget-title Widget-title--min Widget-title--color30 u-bold">{{ $subject->subject_name }}</span>
				</td>
				<td data-th="Relevância">
					<span class="Widget-title Widget-title--min Widget-title--color40 u-bold">{{ $subject->relevance }}%</span>
				</td>

				@if(array_key_exists($subject->idsubject, $userSubjects))
				<td data-th="Proficiência">
					<span class="Widget-title Widget-title--min Widget-title--color40 u-bold">{{ $userSubjects[$subject->idsubject]}}%</span>
				</td>
				@else
				<td data-th="Proficiência">
					<a href="/dashboard/simulado/{{ $subject->idsubject }}?schedule=true" class="Button Button--tiny Button--default Button--defaultGreen" title="Simular">Simular</a>
				</td>
				@endif
				<td data-th="Incluir">
					<div class="checkbox checkbox-slider-xs checkbox-slider--b-flat u-noMargin">
						<label for="{{ $subject->idsubject }}">
							<input name="{{ $subject->idsubject }}" id="{{ $subject->idsubject }}" type="checkbox" value="{{ $subject->idsubject }}" checked><span></span>
						</label>
					</div>
				</td>
			</tr>
			@endforeach--}}
			Estudando
			<span class="PomodoroList-icon PomodoroList-icon--danger Icon Icon--pomodoroBefore"></span>

			<a href="#" id="pomodoroDone" style="display: none;">
				<ul class="ScheduleTimer-menu">
					Pomodoro concluido!
					<span id="pomodoroDoneOk" class="PomodoroList-icon PomodoroList-icon--success Icon Icon--pomodoroBefore"></span>
				</ul>
			</a>

		</div>

	</div>
</div>
