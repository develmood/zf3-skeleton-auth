<?php
namespace Auth\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class UserTable
{
    private $table;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->table = $tableGateway;
    }

    public function saveUser(User $user)
    {
        $id = (int) $user->id;

        if(0 === $id) {
            $this->table->insert((array) $user);
            return;
        }

        if(! $this->getUser($id)) {
            throw new RuntimeException(sprintf(
                'Cannot update user with identifier %d; does not exist',
                $id
            ));
        }

        $this->table->update((array) $user, ['id' => $id]);
    }

    // public function confirmRegistration($token)
    // {
    //     try {
    //         $result = $this->table->update(['confirmed' => 1], ['token' => $token]);
    //     } catch(\Exception $e) {
    //         return $e->getCode();
    //     }
        
    //     // if email wasnt confirmed before, try to get userdata
    //     if(1 === $result) {
    //         try {
    //             $user = $this->table->select(['token' => $token])->current();
    //             return $user;
    //         } catch (\Exception $e) {
    //             return $e->getCode();
    //         }
    //     }

    //     return false;
    // }
}