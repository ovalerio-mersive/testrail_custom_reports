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
		<a href="javascript:void(0)" class="tab3 <?php echo  $tab == 3 ? 'current' : '' ?>" rel="3"
			onclick="App.Tabs.activate(this)"><?php echo  lang('reports_cpg_form_cases') ?></a>
	</div>
	<div class="tab-body tab-frame">
		<div class="tab tab1">
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