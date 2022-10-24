<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class MUser extends CI_Model
{

    function getAllUser()
    {
        $this->db->select('*');
        $this->db->from('users_dash');
//        $this->db->where('status', 1);
        $this->db->order_By('id', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    function getEditUser($idUser)
    {
        $this->db->select('*');
        $this->db->from('users_dash');
        $this->db->where('id', $idUser);
        $query = $this->db->get();
        return $query->result();
    }

    function chkUsernameEmail($username, $email)
    {
        $this->db->select('id,full_name,username,email');
        $this->db->from('users_dash');
        $this->db->where('status', '1');
        $this->db->group_start()
            ->where('username', $username)
            ->or_where('email', $email)
            ->group_end();
        $query = $this->db->get();
        return $query->result();
    }

    function getUserActivity($user, $type)
    {
        $this->db->select('users_dash_activity.idUserActivity, 
	users_dash_activity.idUser, 
	users_dash_activity.activityName, 
	users_dash_activity.actiontype, 
	users_dash_activity.result, 
	users_dash_activity.postData, 
	users_dash_activity.affectedKey, 
	users_dash_activity.isActive, 
	users_dash.full_name, 
	users_dash.username, 
	users_dash_activity.createdBy, 
	users_dash_activity.createdDateTime,
	users_dash.createdBy as userCreatedBy, 
	users_dash.createdDateTime as userCreatedDateTime, 
	users_dash.updateBy, 
	users_dash.updatedDateTime, 
	users_dash.deleteBy, 
	users_dash.deletedDateTime, 
	users_dash.status');
        $this->db->from('users_dash_activity');
        $this->db->join('users_dash', 'users_dash_activity.idUser = users_dash.id', 'left');
        $this->db->where('isActive', 1);
        if (isset($user) && $user != '' && $user != 0) {
            $this->db->where('idUser', $user);
        }

        $this->db->order_By('idUserActivity', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    function getUserLoginActivity($user, $type)
    {

        $where = '';
        if (isset($user) && $user != '' && $user != 0) {
            $where .= ' AND users_dash.id=' . $user;
        }
        $sql_query = "SELECT
	user_failed_logins.id,
	user_failed_logins.idUser,
	user_failed_logins.ip_address,
	CAST(user_failed_logins.attempted_at as datetime) as attempted_at,
	user_failed_logins.result,
	users_dash.id,
	users_dash.username,
	users_dash.email,
	users_dash.full_name 
FROM
	dbo.user_failed_logins
	LEFT JOIN dbo.users_dash ON user_failed_logins.idUser = users_dash.username 
	OR user_failed_logins.idUser = users_dash.email 
	where 1=1 $where
	order by CAST(user_failed_logins.attempted_at as datetime) desc";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

    function getUserLog($user)
    {

        $where = '';
        if (isset($user) && $user != '' && $user != 0) {
            $where .= ' AND u.id=' . $user;
        }
        $sql_query = "SELECT 
	u.id,
	u.full_name,
	u.username, 
	[group].groupName,
	u.status,
	(select username from users_dash where id=u.createdBy) as createdBy,
	CAST(u.createdDateTime as datetime) as createdDateTime, 
	(select username from users_dash where id=u.updateBy) as updateBy,
	CAST(u.updatedDateTime as datetime) as updatedDateTime, 
	(select username from users_dash where id=u.deleteBy) as deleteBy,
	CAST(u.deletedDateTime as datetime) as deletedDateTime 
FROM
	 users_dash u
	LEFT JOIN dbo.[group] ON u.idGroup = [group].idGroup 
WHERE  1=1 $where  ";
        $query = $this->db->query($sql_query);
        return $query->result();
    }

    function getLastLogin($user)
    {

        $where = '';
        if (isset($user) && $user != '' && $user != 0) {
            $where .= ' AND  idUser=' . $user;
        }
        $sql_query = "SELECT TOP
	1 * 
FROM
	[dbo].[users_dash_activity] 
WHERE  activityName = 'Login' 
	AND result LIKE '%Login success%' $where
ORDER BY
	idUserActivity DESC";
        $query = $this->db->query($sql_query);
        return $query->result();
    }
}