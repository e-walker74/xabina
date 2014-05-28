--- 
--- 27.05.2014 - test of rbac accounts access
---

-- add new role
INSERT INTO `rbac_roles` (`id`, `name`, `is_system`, `create_uid`, `parent_id`) 
VALUES(6, 'Минимальные возможности', 0, 92, NULL);

-- add new access right
INSERT INTO `rbac_access_rights` (`id`, `parent_id`, `name`, `additional_parameters`, `action_id`) 
VALUES(1, NULL, 'Доступ в раздел “Банковский перевод”', '', NULL);

-- connect role and user 
INSERT INTO `rbac_user_roles` (`id`, `user_id`, `role_id`, `create_uid`, `account_id`) 
VALUES(2, 93, 6, 92, NULL);

-- connect role and access right
INSERT INTO `rbac_role_access_rights` (`role_id`, `acces_right_id`, `additional_parameters`) 
VALUES(6, 1, NULL);

-- connect user and access right
INSERT INTO `rbac_user_access_rights` (`user_id`, `role_id`, `access_right_id`, `account_id`, `additional_parameters`) 
VALUES(93, 6, 1, NULL, NULL);

