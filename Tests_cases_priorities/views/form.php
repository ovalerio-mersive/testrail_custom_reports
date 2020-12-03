<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php $tab = 1 ?>

<input type="hidden" name="tab" id="tab" />

<div class="tabs">
	<div class="tab-header">
		<a href="javascript:void(0)" class="tab1 <?php echo  $tab == 1 ? 'current' : '' ?>" rel="1"
			onclick="App.Tabs.activate(this)"><?php echo  lang('reports_cpg_form_grouping') ?></a>
		<a href="javascript:void(0)" class="tab2 <?php echo  $tab == 2 ? 'current' : '' ?>" rel="2"
			onclick="App.Tabs.activate(this)">
			<?php if ($project->suite_mode == TP_PROJECTS_SUITES_SINGLE): ?>
			<?php echo  lang('reports_cpg_form_sections') ?>
			<?php else: ?>
			<?php echo  lang('reports_cpg_form_suites') ?>
			<?php endif ?>
		</a>
	</div>
	<div class="tab-body tab-frame">
		<div class="tab tab1 <?php echo  $tab != 1 ? 'hidden' : '' ?>">
			<?php $report_obj->render_control(
				$controls,
				'cases_grouping',
				array(
					'top' => true,
					'intro' => lang('reports_cpg_form_cases_groupby'),
					'attributes' => $case_groupby
				)
			) ?>
			<p><?php echo  lang('reports_cpg_form_cases_details') ?></p>
			<div class="checkbox form-checkbox" style="margin-left: 15px">
				<label>
					<?php echo  lang('reports_cpg_form_cases_include_summary') ?>
					<input type="checkbox" id="custom_cases_include_summary"
						name="custom_cases_include_summary"
						value="1"
						<?php echo  validation::get_checked('custom_cases_include_summary', 1) ?> />
				</label>
			</div>
			<div class="checkbox" style="margin-left: 15px">
				<label>
					<?php echo  lang('reports_cpg_form_cases_include_cases') ?>
					<input type="checkbox" id="custom_cases_include_details"
						name="custom_cases_include_details"
						value="1"
						<?php echo  validation::get_checked('custom_cases_include_details',
							1) ?> />
				</label>
			</div>
		</div>
		<div class="tab tab2 <?php echo  $tab != 2 ? 'hidden' : '' ?>">
			<?php $report_obj->render_control(
				$controls,
				'suites_select',
				array(
					'top' => true,
					'project' => $project
				)
			) ?>
			<?php $report_obj->render_control(
				$controls,
				'sections_select',
				array(
					'top' => true,
					'project' => $project
				)
			) ?>
		</div>
	</div>
</div>

<div style="margin-top: 1em">
	<?php $report_obj->render_control($controls, 'content_hide_links') ?>
</div>