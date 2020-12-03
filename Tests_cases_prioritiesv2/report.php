<?php

/**
 * Copyright Gurock Software GmbH. See license.md for details.
 *
 * This is the official template for developing report plugins for
 * TestRail.
 *
 * http://docs.gurock.com/testrail-custom/reports-introduction
 * http://www.gurock.com/testrail/
 */

class Tests_cases_prioritiesv2_report_plugin extends Report_plugin
{
	private $_controls;

	// The controls and options for those controls that are used on
	// the form of this report.
	private static $_control_schema = array(
		'suites_select' => array(
			'namespace' => 'custom_suites'
		),
		'sections_select' => array(
			'namespace' => 'custom_sections'
		),
		'content_hide_links' => array(
			'namespace' => 'custom_content'
		)
	);

	// The resources (files) to copy to the output directory when
	// generating a report.
	private static $_resources = array(
		'js/jquery.js',
		'styles/print.css',
		'styles/reset.css',
		'styles/view.css'
	);

	public function __construct()
	{
		parent::__construct();
		$this->_controls = $this->create_controls(
			self::$_control_schema
		);
	}

	public function prepare_form($context, $validation)
	{
		// Assign the validation rules for the controls used on the
		// form.
		$this->prepare_controls($this->_controls, $context, $validation);
	}

	public function validate_form($context, $input, $validation)
	{
		$project = $context['project'];
		$cases_groupby = $this->_get_groupby($project);

		$values = $this->validate_controls(
			$this->_controls,
			$context,
			$input,
			$validation);

		if (!$values)
		{
			return false;
		}
	}

	private function _get_groupby($project)
	{
		$attributes = array(
			'day' => lang('reports_cas_form_cases_groupby_day'),
			'month' => lang('reports_cas_form_cases_groupby_month'),
			'suite' =>
				$project->suite_mode == TP_PROJECTS_SUITES_SINGLE ?
					lang('reports_cas_form_cases_groupby_cases') :
					lang('reports_cas_form_cases_groupby_suite')
		);

		asort($attributes);
		return $attributes;
	}

	public function render_form($context)
	{
		$project = $context['project'];

		$params = array(
			'controls' => $this->_controls,
			'project' => $project,
			'case_groupby' => $this->_get_groupby($project)
		);

		return array(
			'form' => $this->render_view(
				'form',
				$params,
				true
			),
			'after_form' => $this->render_view(
				'form_dialogs',
				$params,
				true
			)
		);
	}

	public function run($context, $options)
	{
		$project = $context['project'];

		// We read the test suites first.
		$suites = $this->_helper->get_suites_by_include(
			$project->id,
			$options['suites_ids'],
			$options['suites_include']
		);

		$suite_ids = obj::get_ids($suites);

		// Limit this report to specific test cases, if requested.
        // This is only relevant for single-suite projects and with a
        // section filter.
        $case_ids = $this->_helper->get_case_scope_by_include(
            $suite_ids,
            arr::get($options, 'sections_ids'),
            arr::get($options, 'sections_include'),
            $has_cases
        );

		// Render the report to a temporary file and return the path
        // to TestRail (including additional resources that need to be
        // copied).
        return array(
            'resources' => self::$_resources,
            'html_file' => $this->render_page(
                'index',
                array(
                    'report' => $context['report'],
                    'project' => $project,
                    'suites' => $suites,
                    'case_groupby' => $options['cases_groupby'],
                    'show_links' => !$options['content_hide_links']
                )
            )
        );
	}
}
