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
	private $_model;

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
		// initialize the db model
		$this->_model = new Tests_cases_prioritiesv2_summary_model();
		$this->_model->init();

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

		$values = $this->validate_controls(
			$this->_controls,
			$context,
			$input,
			$validation);

		if (!$values)
		{
			return false;
		}
		return $values;
	}

	public function render_form($context)
	{
		$project = $context['project'];

		$params = array(
			'controls' => $this->_controls,
			'project' => $project
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

        // read data from the database
        $section_ids = $context['report']->custom_options['sections_ids'];
		//$section_ids = "'" . implode("','",$section_ids) . "'";
		$section_ids = arr::get($options, 'sections_ids');
        $cases = $this->_model->get_cases_from_section($section_ids);

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
					'options' => $options,
					'section_ids' => $section_ids,
					'suite_ids' => $suite_ids,
					'cases' => $cases,
					// 'query' => "SELECT c.id as case_id, s.id as section_id, s.name as section_name, p.name as priority_name FROM cases c, sections s, priorities p WHERE c.section_id in ('$section_ids');",
                    'show_links' => !$options['content_hide_links']
                )
            )
        );
	}
}

class Tests_cases_prioritiesv2_summary_model extends BaseModel
{
	public function get_cases_from_section($section_ids)
	{
		$query = $this->db->query(
			'SELECT
			    cases.id as case_id,
			    sections.id as section_id,
			    sections.name as section_name,
			    priorities.name as priority_name
			FROM
			    cases, sections, priorities
			WHERE
				cases.section_id=sections.id and cases.priority_id=priorities.id and
				cases.section_id = 3;',
			$section_ids
		);

		$results = $query->result();
		return $results;
		// return obj::get_lookup_scalar(
		// 	$results,
		// 	'case_id',
		// 	$results
		// );
	}
}
