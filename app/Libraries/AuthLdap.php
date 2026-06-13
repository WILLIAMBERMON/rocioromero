<?php namespace App\Libraries;

/**
 * Class AuthLdap
 * @package AuthLdap\Libraries
 * @author Karthikeyan C <karthikn.mca@gmail.com>
 */
class AuthLdap
{
    const DEFAULT_PORT = "389";
    const TLS_PORT = "636";
    const DEFAULT_USER_PASSWORD = "1234UFPS";

    //Connection attributes
    private $_user;
    private $_password;
    private $_host;
    private $_base_dn;
    private $_port;
    private $_connection;
    private $_bind;

    /**
     * Ldap constructor.
     */
    public function __construct()
    {
        $this->_base_dn = "dc=ufps,dc=edu,dc=co";
        $this->_user = "";
        $this->_password = "";
        $this->_host = "ldap://ldap.ufps.edu.co/";
        $this->_port = self::DEFAULT_PORT;
        $this->_connection = null;
        $this->_bind = false;
    }

    /**
     * @param $options
     * @return bool
     */
    public function set_options($options)
    {
        $keys_needed = ['user', 'password', 'connection', 'base_dn', 'port'];
        foreach ($keys_needed as $kn) {
            if (!array_key_exists($kn, $options)) return false;
        }
        $this->_user = $options['user'];
        $this->_password = $options['password'];
        $this->_host = $options['connection'];
        $this->_base_dn = $options['base_dn'];
        $this->_port = $options['port'];
    }

    public function encrypt_password($password)
    {
        return "{SHA}" . base64_encode(pack("H*", sha1($password)));
    }

    /**
     *
     */
    private function _connect()
    {
        if (!$this->_connection)
            $this->_connection = ldap_connect($this->_host, $this->_port);
    }

    /**
     *
     */
    private function _close()
    {
        if ($this->_connection) {
            ldap_close($this->_connection);
            $this->_connection = null;
            $this->_bind = false;
        }
    }

    /**
     *
     */
    private function _bind()
    {
        if (!$this->_connection) {
            $this->_connect();
        }
        if (!$this->_bind) {
            ldap_set_option($this->_connection, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_set_option($this->_connection, LDAP_OPT_REFERRALS, 0);
            if (!$this->_user && !$this->_password) return false;
            $this->_bind = ldap_bind($this->_connection, $this->_user, $this->_password);
        }
    }

    /**
     * @return bool
     */
    public function auth($user, $password)
    {
        $this->_user = "uid={$user},ou=People,{$this->_base_dn}";
        $this->_password = $password;

        $this->_bind();
        $result = $this->_bind;
        $this->_close();

        return $result;
    }

    /**
     * WARNING!!
     * Do not use this function in production environments
     */
    public function manager_auth()
    {
        $this->_user = "cn=Manager,{$this->_base_dn}";
        $this->_password = base64_decode("M0wxdDMwbjM4MDA=");

        $this->_bind();
        $result = $this->_bind;
        $this->_close();

        return $result;
    }

    public function lookup_auth()
    {
        $this->_user = "cn=Lookup,{$this->_base_dn}";
        $this->_password = base64_decode("bG9va3VwVWZwcw==");

        $this->_bind();
        $result = $this->_bind;
        $this->_close();

        return $result;
    }

    /**
     * @param null $rdn
     * @return bool
     */
    public function delete($rdn = null)
    {
        if (!$rdn) {
            return false;
        }

        $dn = "{$rdn},{$this->_base_dn}";

        if (!$this->_bind) $this->_bind();
        $result = ldap_delete($this->_connection, $dn);
        $this->_close();

        return $result;
    }

    /**
     * @param $filters
     * @param $attributes
     * @return array | bool
     */
    public function search($filters, $attributes)
    {
        if (!$this->_bind) $this->_bind();
        $result = ldap_search($this->_connection, $this->_base_dn, $filters, $attributes);
        $entries = ldap_get_entries($this->_connection, $result);
        $this->_close();
        return $entries;
    }

    /**
     * @param string $uid
     * @return array|bool
     */
    public function search_uid($uid = '*')
    {
        $filters = "(uid={$uid})";
        $attributes = ["sn", "mail", "uid", "cn", "userPassword", "title"];
        return $this->search($filters, $attributes);
    }

    /**
     * @param $uid
     * @return bool
     */
    public function is_person($uid)
    {
        $result = $this->search_uid($uid);
        return $result["count"] > 0 ? (object)$this->_result2object($result[0]) : false;
    }

    public function _result2object($result, $object = null, $last_index = "dn")
    {
        foreach ($result as $index => $item) {
            if (!is_numeric($index)) {
                if (is_array($item)) {
                    if (!is_array($item[0])) {
                        $object[$index] = $item[0];
                    }
                } elseif (!is_array($item)) {
                    $object[$index] = $item;
                }
            }
        }
        return $object;
    }

    /*public function add_persons($persons, $show = false, $names = false, $tipo)
    {
        $connection = ldap_connect($this->_host, $this->_port);
        $agregados = array();
        $errores = array();

        if ($connection) {

            $this->_user = "cn=Manager,{$this->_base_dn}";
            $this->_password = base64_decode("M0wxdDMwbjM4MDA=");
            ldap_set_option($connection, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_set_option($connection, LDAP_OPT_REFERRALS, 0);
            $bind = ldap_bind($connection, $this->_user, $this->_password);

            $i = 0;

            foreach ($persons as $person) {

                $id = $person->DOCUMENTO;
                $mail = isset($person->EMAILI) ? $person->EMAILI : "";
                $password = isset($person->CLAVE) ? $person->CLAVE : self::DEFAULT_USER_PASSWORD;
                $title = '0';

                if ($names) {
                    $person_names = explode(" ", $person->NOMBRES);
                    $first_name = isset($person_names[2]) ? $person_names[2] : (isset($person->PRIMER_NOMBRE) ? $person->PRIMER_NOMBRE : "");
                    $last_name = isset($person_names[0]) ? $person_names[0] : (isset($person->PRIMER_APELLIDO) ? $person->PRIMER_APELLIDO : "");
                } else {
                    $first_name = isset($person->PRIMER_NOMBRE) ? $person->PRIMER_NOMBRE : "";
                    $last_name = isset($person->PRIMER_APELLIDO) ? $person->PRIMER_APELLIDO : "";
                }

                $entry = [
                    "objectClass" => [
                        0 => "top",
                        1 => "person",
                        2 => "organizationalPerson",
                        3 => "inetOrgPerson"
                    ],
                    "uid" => $id,
                    "cn" => $first_name,
                    "sn" => $last_name,
                    "mail" => $mail,
                    "userPassword" => $this->encrypt_password($password),
                    "title" => $title
                ];

                $userDn = "uid={$id},ou=People,{$this->_base_dn}";

                if ($tipo = "docente") {
                    $result_people = ldap_add($connection, $userDn, $entry);

                    $dn = "cn=teachers,ou=Group,{$this->_base_dn}";
                    $entry_group["memberUid"] = $entry['uid'];
                    $result_group = ldap_mod_add($this->_connection, $dn, $entry_group);

                    $result = $result_people && $result_group;
                } else {
                    $result = ldap_add($connection, $userDn, $entry);
                }

                if ($result) {
                    if ($show) {
                        echo "\r\t\t\r" . $i;
                        $i++;
                    }
                    array_push($agregados, $person);
                } else {
                    array_push($errores, $person);
                }
            }
            ldap_close($connection);
            if ($show) {
                echo PHP_EOL;
            }
            return ["agregados" => $agregados, "errores" => $errores];
        } else {
            return false;
        }

    }

    /**
     * @param $person
     * @param bool $check_user
     * @return bool
     */
    public function add_person($person, $check_user = true)
    {
        $id = $person['id'];
        $first_name = isset($person['first_name']) ? $person['first_name'] : "";
        $last_name = isset($person['last_name']) ? $person['last_name'] : "";
        $mail = isset($person['mail']) ? $person['mail'] : "";
        $password = isset($person['password']) ? $person['password'] : self::DEFAULT_USER_PASSWORD;
        $title = isset($person['title']) ? $person['title'] : '0';

        if ($check_user) {
            $search = $this->search_uid($id);
            if ($search['count']) return false;
        }

        if (!$this->_bind) $this->_bind();
        $entry = [
            "objectClass" => [
                0 => "top",
                1 => "person",
                2 => "organizationalPerson",
                3 => "inetOrgPerson"
            ],
            "uid" => $id,
            "cn" => $first_name,
            "sn" => $last_name,
            "mail" => $mail,
            "userPassword" => $this->encrypt_password($password),
            "title" => $title
        ];

        $userDn = "uid={$id},ou=People,{$this->_base_dn}";

        $result = ldap_add($this->_connection, $userDn, $entry);
        $this->_close();

        return $result;
    }

    /**
     * @param $person
     * @return bool
     */
    public function update_person($person)
    {
        if (!array_key_exists("id", $person) && count($person) < 2) return false;

        $search = $this->search_uid($person["id"]);
        if (!$search['count']) return false;

        if (!$this->_bind) $this->_bind();
        if (isset($person["first_name"])) $entry["cn"] = $person["first_name"];
        if (isset($person["last_name"])) $entry["sn"] = $person["last_name"];
        if (isset($person["mail"])) $entry["mail"] = $person["mail"];
        if (isset($person["password"])) {
            $password = $this->encrypt_password($person["password"]);
            $entry["userPassword"] = $password;
        }
        if (isset($person["title"])) $entry["title"] = $person["title"];

        $userDn = "uid={$person["id"]},ou=People,{$this->_base_dn}";
        $result = ldap_modify($this->_connection, $userDn, $entry);
        $this->_close();

        return $result;
    }

    /**
     * @param $member_uid
     * @param $group_name
     * @return array|bool
     */
    public function is_member($member_uid, $group_name)
    {
        $filters = "(&(objectClass=posixGroup)(cn={$group_name})(memberUid={$member_uid}))";
        $attributes = ["cn", "gidNumber"];
        return $this->search($filters, $attributes);
    }

    /**
     * @param $group_name
     * @return bool
     */
    public function group_exist($group_name)
    {
        $filters = "(&(objectClass=posixGroup)(cn={$group_name}))";
        $attributes = ["cn", "gidNumber"];
        $result = $this->search($filters, $attributes);
        return $result['count'] > 0 ? true : false;
    }

    /**
     * @param $member_uid
     * @param $group_name
     * @return bool
     */
    public function add_member($member_uid, $group_name)
    {
        if (!$this->group_exist($group_name)) return false;
        if (!$this->is_person($member_uid)) return false;

        if (!$this->_bind) $this->_bind();
        $dn = "cn={$group_name},ou=Group,{$this->_base_dn}";
        $entry["memberUid"] = $member_uid;
        $result = ldap_mod_add($this->_connection, $dn, $entry);
        $this->_close();

        return $result;
    }

    /**
     * @param $member_uid
     * @param $group_name
     * @return bool
     */
    public function delete_member($member_uid, $group_name)
    {
        if (!$this->is_person($member_uid)) return false;

        if (!$this->_bind) $this->_bind();
        $dn = "cn={$group_name},ou=Group,{$this->_base_dn}";
        $entry["memberUid"] = $member_uid;
        $result = ldap_mod_del($this->_connection, $dn, $entry);
        $this->_close();

        return $result;
    }

    public function delete_person($member_uid)
    {
        if (!$this->is_person($member_uid)) return false;

        $rdn = "uid={$member_uid},ou=People";
        return $this->delete($rdn);
    }
}