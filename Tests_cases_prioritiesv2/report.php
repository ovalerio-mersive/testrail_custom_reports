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
		$section_ids = arr::get($options, 'sections_ids');

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
					'sections' => $this->_model->get_sections($section_ids),
					'suite_ids' => $suite_ids,
					'cases' => $this->_model->get_cases_from_section($section_ids),
					'automated_p1_cases' => $this->_model->get_total_automated_p1_testcases($section_ids, 3), // 3 is the id for high priority
					'total_automated_cases' => $this->_model->get_total_automated_test_cases($section_ids),
					'priorities' => $this->_model->get_priorities(),
					'show_links' => !$options['content_hide_links']
                )
            )
        );
	}
}

class Tests_cases_prioritiesv2_summary_model extends BaseModel
{
	public function get_sections($section_ids) {
		if ($section_ids == "") {
			$query = $this->db->query(
				'SELECT 
					* 
				FROM 
					sections;'
			);
		} else {
			$query = $this->db->query(
				'SELECT 
					* 
				FROM 
					sections
				WHERE 
					id in ({0});',
				$section_ids
			);
		}
		return $query->result();
	}

	public function get_total_automated_test_cases($section_ids) {
		$query = $this->db->query(
			'SELECT 
				count(*) as total_automated_tcs
			FROM 
				cases c, priorities p 
			WHERE 
				c.priority_id=p.id AND type_id=(
												SELECT 
													id 
												FROM 
													case_types 
												WHERE
													id=(
														SELECT 
															id 
														FROM 
															case_types 
														WHERE 
															name="Automated"
													) and c.section_id in ({0})
												);',
			$section_ids	
		);
		return $query->result();
	}

	public function get_total_automated_p1_testcases($section_ids, $priority_id) {
		$query = $this->db->query(
			'SELECT 
				count(*) as total_automated_tcs_with_priority 
			FROM 
				cases c, priorities p 
			WHERE 
				c.priority_id=p.id AND p.priority={0} AND type_id=(
																SELECT 
																	id 
																FROM 
																	case_types 
																WHERE
																	id=(
																		SELECT 
																			id 
																		FROM 
																			case_types 
																		WHERE 
																			name="Automated"
																	) and c.section_id in ({1})
																);',
			$priority_id, $section_ids
		);
		return $query->result();
	}
	
	public function get_cases_from_section($section_ids)
	{
		if ($section_ids == "") {
			$query = $this->db->query(
				'SELECT
					c.id as case_id, 
					c.priority_id as case_p_id, 
					s.name as section_name, 
					s.id as case_s_id, 
					p.name as p_name, 
					p.id as p_id
				FROM
					cases c, sections s, priorities p
				WHERE
					c.section_id=s.id and c.priority_id=p.id'
			);
		} else {
			$query = $this->db->query(
				'SELECT
					c.id as case_id, 
					c.priority_id as case_p_id, 
					s.name as section_name, 
					s.id as case_s_id,
					p.name as p_name,
					p.id as p_id
				FROM
					cases c, sections s, priorities p
				WHERE
					c.section_id=s.id and c.priority_id=p.id and c.section_id in ({0});',
				$section_ids
			);
		}
		
		return $query->result();
	}

	public function get_priorities() {
		$query = $this->db->query(
			'SELECT
				*
			FROM
				priorities;'
		);
		return $query->result();
	}
}
