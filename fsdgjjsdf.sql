// agent inbound call report

SELECT
  admin_id,
  full_name,
  DATE(stats.update_datetime) AS call_date,
  TIME(stats.update_datetime) AS TIME,
  SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(stats.staff_end_datetime,stats.staff_start_datetime)))) AS inbound_call_duration,
  SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF( stats.enqueue_datetime,stats.dequeue_datetime)))) AS wait_in_queue,
  stats.caller_id     AS caller_id,
  stats.unique_id     AS call_id,
  department,
  users.cmid,
  users.uin,
  ticket.number,
  ticket_data.subject,
  depart.dept_name,
  tstatus.name
FROM cc_admin AS admin
  LEFT JOIN cc_queue_stats AS stats
    ON admin.admin_id = stats.staff_id
      AND DATE(stats.update_datetime) BETWEEN '2015-12-08'
      AND '2015-12-10'
      AND stats.call_type = 'INBOUND'
      
  LEFT JOIN ts_ticket AS ticket
    ON stats.unique_id = ticket.unique_id
  LEFT JOIN ts_user AS users
    ON ticket.user_id = users.id
  LEFT JOIN ts_ticket__cdata AS ticket_data
    ON ticket.ticket_id = ticket_data.ticket_id
  LEFT JOIN ts_department AS depart
    ON ticket.dept_id = depart.dept_id
  LEFT JOIN ts_ticket_status AS tstatus
    ON tstatus.id = ticket.status_id
WHERE admin.admin_id = '9039'
GROUP BY admin.admin_id,stats.call_type,stats.update_datetime

Summary Report

SELECT admin_id,full_name,COUNT( DISTINCT stats.id) AS inbound_call_no, SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(stats.staff_end_datetime,stats.staff_start_datetime)))) AS inbound_call_duration, SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF( stats.update_datetime,stats.staff_end_datetime)))) AS inbound_busy_duration, COUNT(DISTINCT stats2.id) AS outbound_call_no, SEC_TO_TIME(SUM( DISTINCT TIME_TO_SEC(TIMEDIFF(stats2.staff_end_datetime,stats2.staff_start_datetime)))) AS outbound_call_duration, SEC_TO_TIME(SUM( DISTINCT TIME_TO_SEC(TIMEDIFF(stats2.update_datetime,stats2.staff_end_datetime)))) AS outbound_busy_duration, COUNT(DISTINCT abandoned.id) AS abandon_calls, COUNT(DISTINCT stats3.call_status) AS droped_calls, SEC_TO_TIME(SUM(DISTINCT TIME_TO_SEC(TIMEDIFF(break.end_datetime, break.start_datetime)))) AS break_time, SEC_TO_TIME(SUM(DISTINCT TIME_TO_SEC(TIMEDIFF(assignment.end_datetime, assignment.start_datetime)))) AS assignment_time, TIME(MIN(login_datetime)) AS login_time, CASE TIME(MAX(login_datetime)) WHEN TIME(MAX(logout_datetime)) THEN TIMEDIFF(NOW(), MIN(login_datetime)) ELSE TIMEDIFF(MAX(logout_datetime),MIN(login_datetime)) END AS login_duration , CASE TIME(MAX(login_datetime)) WHEN TIME(MAX(logout_datetime)) THEN TIME(NOW()) ELSE TIME(MAX(logout_datetime)) END AS logout_time, department FROM cc_admin AS admin LEFT JOIN cc_queue_stats AS stats ON admin.admin_id = stats.staff_id AND DATE(stats.update_datetime) = '2015-12-16' AND stats.call_type = 'INBOUND' AND TIMEDIFF(stats.staff_end_datetime,stats.staff_start_datetime) <> '00:00:00' LEFT JOIN cc_queue_stats AS stats2 ON admin.admin_id = stats2.staff_id AND DATE(stats2.update_datetime) = '2015-12-16' AND stats2.call_type = 'OUTBOUND' AND TIMEDIFF(stats2.staff_end_datetime,stats2.staff_start_datetime) <> '00:00:00' LEFT JOIN cc_queue_stats AS stats3 ON admin.admin_id = stats3.staff_id AND DATE(stats3.update_datetime) = '2015-12-16' AND stats3.call_status = 'DROP' AND TIMEDIFF(stats3.staff_end_datetime,stats3.staff_start_datetime) <> '00:00:00' LEFT JOIN cc_abandon_calls AS abandoned ON admin.admin_id = abandoned.staff_id AND DATE(abandoned.update_datetime) = '2015-12-16' LEFT JOIN cc_crm_activity AS break ON admin.admin_id = break.staff_id AND DATE(break.update_datetime) = '2015-12-16' AND break.status = 4 AND TIMEDIFF(break.end_datetime, break.start_datetime) <> '00:00:00' LEFT JOIN cc_crm_activity AS assignment ON admin.admin_id = assignment.staff_id AND DATE(assignment.update_datetime) = '2015-12-16' AND assignment.status = 6 AND TIMEDIFF(assignment.end_datetime, assignment.start_datetime) <> '00:00:00' LEFT JOIN cc_login_activity AS login_activety ON admin.admin_id = login_activety.staff_id AND DATE(login_activety.login_datetime)='2015-12-16' AND DATE(login_activety.logout_datetime)='2015-12-16' WHERE admin_id = '9039' GROUP BY admin.admin_id,stats.call_type,stats2.call_type,stats3.call_status,break.status,assignment.status,login_activety.login_datetime


9030 , 9044 , 9082 , 9039 , 9078 , 9079 ,9080 ,9081 ,9083 ,9084 ,9085 ,9086 ,9087 ,9088 , 9089 ,9090 ,9036 ,9037