<?php

use OAuth\OAuth2\Service\GitHub;

/**
 * Service Implementation for oAuth Github authentication
 */
class action_plugin_oauthgithub extends \dokuwiki\plugin\oauth\Adapter
{

    /** * @inheritDoc */
    public function getUser()
    {
        $oauth = $this->getOAuthService();
        $data = array();

        // basic user data
        $result = json_decode($oauth->request('user'), true);
        $data['user'] = $result['login'];
        $data['name'] = $result['name'];

        // primary email address
        $result = json_decode($oauth->request('user/emails'), true);
        foreach ($result as $row) {
            if (!empty($row['primary']) && !empty($row['verified'])) {
                $data['mail'] = $row['email'];
                break;
            }
        }

        return $data;
    }

    /** @inheritDoc */
    public function getScopes()
    {
        return [GitHub::SCOPE_USER_EMAIL];
    }

    /** @inheritDoc */
    public function getLabel()
    {
        return 'GitHub';
    }

    /** @inheritDoc */
    public function getColor()
    {
        return '#404041';
    }

}
