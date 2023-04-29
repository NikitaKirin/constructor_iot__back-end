BEGIN;
-- protect against concurrent inserts while you update the counter
LOCK TABLE users IN EXCLUSIVE MODE;
-- Update the sequence
SELECT setval('users_id_seq', COALESCE((SELECT MAX(id)+1 FROM users), 1), false);
COMMIT;

BEGIN;
-- protect against concurrent inserts while you update the counter
LOCK TABLE attachments IN EXCLUSIVE MODE;
-- Update the sequence
SELECT setval('attachments_id_seq', COALESCE((SELECT MAX(id)+1 FROM attachments), 1), false);
COMMIT;

BEGIN;
-- protect against concurrent inserts while you update the counter
LOCK TABLE attachmentable IN EXCLUSIVE MODE;
-- Update the sequence
SELECT setval('attachmentable_id_seq', COALESCE((SELECT MAX(id)+1 FROM attachmentable), 1), false);
COMMIT;

BEGIN;
-- protect against concurrent inserts while you update the counter
LOCK TABLE disciplines IN EXCLUSIVE MODE;
-- Update the sequence
SELECT setval('disciplines_id_seq', COALESCE((SELECT MAX(id)+1 FROM disciplines), 1), false);
COMMIT;


BEGIN;
-- protect against concurrent inserts while you update the counter
LOCK TABLE course_assemblies IN EXCLUSIVE MODE;
-- Update the sequence
SELECT setval('course_assemblies_id_seq', COALESCE((SELECT MAX(id)+1 FROM course_assemblies), 1), false);
COMMIT;

BEGIN;
-- protect against concurrent inserts while you update the counter
LOCK TABLE employees IN EXCLUSIVE MODE;
-- Update the sequence
SELECT setval('employees_id_seq', COALESCE((SELECT MAX(id)+1 FROM employees), 1), false);
COMMIT;

BEGIN;
-- protect against concurrent inserts while you update the counter
LOCK TABLE partners IN EXCLUSIVE MODE;
-- Update the sequence
SELECT setval('partners_id_seq', COALESCE((SELECT MAX(id)+1 FROM partners), 1), false);
COMMIT;

BEGIN;
-- protect against concurrent inserts while you update the counter
LOCK TABLE reviews IN EXCLUSIVE MODE;
-- Update the sequence
SELECT setval('reviews_id_seq', COALESCE((SELECT MAX(id)+1 FROM reviews), 1), false);
COMMIT;

BEGIN;
-- protect against concurrent inserts while you update the counter
LOCK TABLE professions IN EXCLUSIVE MODE;
-- Update the sequence
SELECT setval('professions_id_seq', COALESCE((SELECT MAX(id)+1 FROM professions), 1), false);
COMMIT;

BEGIN;
-- protect against concurrent inserts while you update the counter
LOCK TABLE professional_trajectories IN EXCLUSIVE MODE;
-- Update the sequence
SELECT setval('professional_trajectories_id_seq', COALESCE((SELECT MAX(id)+1 FROM professional_trajectories), 1), false);
COMMIT;

BEGIN;
-- protect against concurrent inserts while you update the counter
LOCK TABLE frequently_asked_questions IN EXCLUSIVE MODE;
-- Update the sequence
SELECT setval('frequently_asked_questions_id_seq', COALESCE((SELECT MAX(id)+1 FROM frequently_asked_questions), 1), false);
COMMIT;

BEGIN;
-- protect against concurrent inserts while you update the counter
LOCK TABLE courses IN EXCLUSIVE MODE;
-- Update the sequence
SELECT setval('courses_id_seq', COALESCE((SELECT MAX(id)+1 FROM courses), 1), false);
COMMIT;

BEGIN;
-- protect against concurrent inserts while you update the counter
LOCK TABLE roles IN EXCLUSIVE MODE;
-- Update the sequence
SELECT setval('roles_id_seq', COALESCE((SELECT MAX(id)+1 FROM roles), 1), false);
COMMIT;
