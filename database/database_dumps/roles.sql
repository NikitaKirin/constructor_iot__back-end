-- -------------------------------------------------------------
-- TablePlus 4.8.8(450)
--
-- https://tableplus.com/
--
-- Database: c65638_staging_api_iot_nik_web_ru
-- Generation Time: 2023-04-08 20:05:44.0600
-- -------------------------------------------------------------


INSERT INTO "public"."roles" ("id", "slug", "name", "permissions", "created_at", "updated_at") VALUES
(1, 'admin', 'Администратор', '{"faq": "1", "logs": "1", "courses": "1", "reviews": "1", "contacts": "1", "partners": "1", "employees": "1", "institutes": "1", "disciplines": "1", "professions": "1", "platform.index": "1", "educationalModules": "1", "educationalPrograms": "1", "platform.systems.roles": "1", "platform.systems.users": "1", "professionalTrajectories": "1", "platform.systems.attachment": "1"}', '2023-04-06 23:03:31', '2023-04-06 23:03:31'),
(2, 'editor', 'Редактор', '{"faq": "1", "logs": "0", "courses": "1", "reviews": "1", "contacts": "1", "partners": "1", "employees": "1", "institutes": "1", "disciplines": "1", "professions": "1", "platform.index": "1", "educationalModules": "1", "educationalPrograms": "1", "platform.systems.roles": "0", "platform.systems.users": "0", "professionalTrajectories": "1", "platform.systems.attachment": "1"}', '2023-04-06 23:04:18', '2023-04-06 23:06:18');
