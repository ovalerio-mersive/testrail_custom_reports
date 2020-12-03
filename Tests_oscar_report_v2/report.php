
<?php
class Tests_oscar_report_v2_report_plugin extends Report_plugin
{
	private $_model;
	private $_controls;

	// The controls and options for those controls that are used on
	// the form of this report.
	private static $_control_schema = array(
		'runs_select' => array(
			'namespace' => 'custom_runs',
			'multiple_suites' => true
		),
		'runs_limit' => array(
			'type' => 'limits_select',
			'namespace' => 'custom_runs',
			'min' => 0,
			'max' => 100,
			'default' => 10
		)
	);

	// The resources (files) to copy to the output directory when
	// generating a report.
	private static $_resources = array(
		'js/highcharts.js',
		'js/jquery.js',
		'styles/print.css',
		'styles/reset.css',
		'styles/view.css'
	);

	public function __construct()
	{
		parent::__construct();
		$this->_model = new Tests_oscar_report_v2_summary_model();
		$this->_model->init();
		$this->_controls = $this->create_controls(
			self::$_control_schema
		);
	}

	public function prepare_form($context, $validation)
	{
		// Assign the validation rules for the controls used on the form.
		$this->prepare_controls($this->_controls, $context, $validation);

		// Assign the validation rules for the fields on the form.
		$validation->add_rules(
			array(
				'custom_types_include' => array(
					'type' => 'bool',
					'default' => false
				),
				'custom_priorities_include' => array(
					'type' => 'bool',
					'default' => false
				)
			)
		);
	
		if (request::is_post())
		{
			return;
		}

		if ($context['event'] == 'add')
		{
			$defaults = array(
				'types_include' => true,
				'priorities_include' => true
			);
		}
		else
		{
			$defaults = $context['custom_options'];
		}
	
		foreach ($defaults as $field => $value)
		{
			$validation->set_default('custom_' . $field, $value);
		}
	}

	public function validate_form($context, $input, $validation)
	{
		// At least one detail entity option must be selected (types or
		// priorities).
		if (!$input['custom_types_include'] && !$input['custom_priorities_include'])
		{
			$validation->add_error(
				lang('reports_tmpl_form_details_include_required')
			);

			return false;
		}

		// We begin with validating the controls used on the form.
		$values = $this->validate_controls(
			$this->_controls,
			$context,
			$input,
			$validation);
 
		if (!$values)
		{
			return false;
		}

		static $fields = array(
			'types_include',
			'priorities_include'
		);

		foreach ($fields as $field)
		{
			$key = 'custom_' . $field;
			$values[$field] = arr::get($input, $key);
		}

		return $values;
	}

	public function render_form($context)
	{
		$params = array(
			'controls' => $this->_controls,
			'project' => $context['project']
		);

		// Note that we return separate HTML snippets for the form/
		// options and the used dialogs (which must be included after
		// the actual form as they include their own <form> tags).
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
					'context' => $context
				)
			)
		);
	}
}

class Tests_oscar_report_v2_summary_model extends BaseModel
{
	public function get_statuses()
	{
		$this->db->select('*');
		$this->db->from('statuses');
		$this->db->where('is_active', true);
		$this->db->order_by('display_order');
		return $this->db->get_result();
	}

	public function get_types()
	{
		$this->db->select('*');
		$this->db->from('case_types');
		$this->db->where('is_deleted', false);
		$this->db->order_by('name', 'asc');
		return $this->db->get_result();
	}

	public function get_type_results($run_ids, $type_id)
	{
		$query = $this->db->query(
			'SELECT
				tests.status_id,
				COUNT(*) as status_count
			FROM
				tests
			JOIN
				cases
					on
				cases.id = tests.content_id
			WHERE
				tests.run_id in ({0}) and
				cases.type_id = {1}
			GROUP BY
				tests.status_id',
			$run_ids,
			$type_id
		);
 
		$results = $query->result();
		return obj::get_lookup_scalar(
			$results,
			'status_id',
			'status_count'
		);
	}

	public function get_priorities()
	{
		$this->db->select('*');
		$this->db->from('priorities');
		$this->db->where('is_deleted', false);
		$this->db->order_by('priority', 'asc');
		return $this->db->get_result();
	}

	public function get_priority_results($run_ids, $priority_id)
	{
		$query = $this->db->query(
			'SELECT
				tests.status_id,
				COUNT(*) as status_count
			FROM
				tests
			JOIN
				cases
					on
				cases.id = tests.content_id
			WHERE
				tests.run_id in ({0}) and
				cases.priority_id = {1}
			GROUP BY
				tests.status_id',
			$run_ids,
			$priority_id
		);

		$results = $query->result();
		return obj::get_lookup_scalar(
			$results,
			'status_id',
			'status_count'
		);
	}
}
