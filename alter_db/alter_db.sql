DROP TABLE IF EXISTS indottech_project_milestones;
indottech_project_milestones
	id
	project_id
	wpo_id
	wpo
	site_id
	site_name
	po

DROP TABLE IF EXISTS indottech_project_milestone_details;
indottech_project_milestone_details
	id
	project_milestone_id
	milestone_id
	milestone_at
