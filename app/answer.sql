select TicketNumber, ch.dt_status, ch.status, cl.id from call_history as ch
    join (SELECT max(call_history.id) as id FROM `call_history` GROUP BY call_history.id_call_list) as last on ch.id=last.id
    join call_list as cl on ch.id_call_list=cl.id
