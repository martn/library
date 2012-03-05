<?php

require_once LIBS_DIR.'/MyLib/Model/StandardModel.php';
//require_once dirname(__FILE__) . '/Base.php';
//require_once dirname(__FILE__) . '/IModel.php';


abstract class BaseModel extends StandardModel {


	const TABLE_MAPS = 			'lib_maps';
	const TABLE_MAPS_ITEMS = 		'lib_maps_items';
	const TABLE_SECTIONS = 			'lib_sections';
	const TABLE_ACL = 			'lib_acl';
	const TABLE_PRIVILEGES = 		'lib_privileges';
	const TABLE_RESOURCES = 		'lib_resources';
	const TABLE_ROLES = 			'lib_roles';
	const TABLE_ACL_JOIN = 			'lib_acl_join';
	const TABLE_ATTRIBUTES_GROUPS =         'lib_attributes_groups';
	const TABLE_TYPES_ATTRIBUTES_GROUPS =   'lib_types_attributes_groups';
	const TABLE_ITEMS = 			'lib_items';
	const TABLE_ITEMS_DATA =		'lib_items_data';
        const TABLE_ITEMS_FTS =                 'lib_items_fts';
	const TABLE_TYPES = 			'lib_types';
	const TABLE_ATTR_LIST_ITEMS =           'lib_attr_list_items';
	const TABLE_ATTRIBUTES = 		'lib_attributes';
	const TABLE_FILES = 			'lib_files';
	const TABLE_GROUPS = 			'lib_acl_join_groups';
	const TABLE_SECTIONS_PRIVILEGES =       'lib_sections_privileges';
	const TABLE_USERS_ROLES = 		'lib_users_roles';
	const TABLE_USERS = 			'lib_users';
	
}
