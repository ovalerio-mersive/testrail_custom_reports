<div class="tabs">
	<div class="tab-header">
		<a href="javascript:void(0)" class="tab1 current" rel="1" onclick="App.Tabs.activate(this)">
				<?= lang('reports_tmpl_form_runs') ?>
		</a>
	</div>
	<div class="tab-body tab-frame">
		<div class="tab tab1">
			<!-- The content of tab 2 goes here -->
			<?php
				$report_obj->render_control(
					$controls,
					'runs_select',
					array(
						'top' => true,
						'project' => $project
					)
					);

				$report_obj->render_control(
					$controls,
					'runs_limit',
					array(
						'intro' => lang('report_plugins_runs_limit'),
						'limits' => array(5, 10, 25, 50, 100, 0)
					)
					);
			?>
		</div>
	</div>
</div>