<?php

require_once LIBS_DIR . '/Nette/Security/IAuthenticator.php';
require_once LIBS_DIR . '/Nette/Utils/Object.php';

class UserAuthenticator extends NObject implements IAuthenticator {
    
    /**
     * @param  array
     * @return IIdentity
     * @throws AuthenticationException
     */
    function authenticate(array $credentials) {
        
        $userModel = new UsersModel();    
        
        $username = strtolower($credentials[self::USERNAME]);

        try {
            $userdata = $userModel->find($username, 'username', 's'); 
        } catch(NotFoundException $e) {
            throw new NAuthenticationException("Uživatelské jméno '$username' neexistuje.", self::IDENTITY_NOT_FOUND);
        }
        
        if ($userdata->passw !== $userModel->encrypt($credentials[self::PASSWORD])) {
            throw new NAuthenticationException("Neplatné heslo.", self::INVALID_CREDENTIAL);
        }

        unset($userdata->passw);
        
        try {
            return $userModel->getIdentity($username);
        } catch(NotFoundException $e) {
            throw new NAuthenticationException("Uživatelské jméno '$username' neexistuje.", self::IDENTITY_NOT_FOUND);
        }
    }
}