<?php if (!defined('ROOTPATH')) exit('No direct script access allowed'); ?>
<?php $tab = 1 ?>

<input type="hidden" name="tab" id="tab" />

<div class="tabs">
    <!-- Header -->
    <div class="tab-header">
        <a href="javascript:void(0)" class="tab1 <?php echo  $tab == 1 ? 'current' : '' ?>" rel="1"
            onclick="App.Tabs.activate(this)">
            <?php if ($project->suite_mode == TP_PROJECTS_SUITES_SINGLE): ?>
            <?php echo  lang('reports_cas_form_sections') ?>
            <?php else: ?>
            <?php echo  lang('reports_cas_form_suites') ?>
            <?php endif ?>
        </a>
    </div>

    <!-- Body -->
    <div class="tab-body tab-frame">
        <p>Body here</p>
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